<?php

declare(strict_types=1);

namespace MStroink\Solax;

use GuzzleHttp\RequestOptions as Options;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use MStroink\Solax\Exception\HttpServerException;
use MStroink\Solax\Exception\UnknownErrorException;
use MStroink\Solax\Http\ClientConfiguratorInterface;
use MStroink\Solax\Http\HttpClientConfigurator;
use MStroink\Solax\Resource\History\History;
use MStroink\Solax\Resource\RealTime\RealTime;
use Psr\Http\Message\ResponseInterface;

class Inverter
{
    protected const ENDPOINT_REALTIME = 'realTimeData.htm';
    protected const ENDPOINT_HISTORY = 'historyData.htm';
    protected const TIMEOUT = 4;
    protected const CONNECT_TIMEOUT = 4;

    /**
     * @var HttpClient;
     */
    protected $client;

    /**
     * @var ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    public function __construct(ClientConfiguratorInterface $configurator, ?RequestFactory $requestFactory = null)
    {
        $this->client = $configurator->createConfiguredClient();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Note the timeout: At night there is not enough sunlight to power the inverter.
     */
    public static function create(
        string $host,
        string $username = 'admin',
        string $password = 'admin'
    ): self {
        $configurator = (new HttpClientConfigurator())
            ->setUsername($username)
            ->setPassword($password)
            ->setHost($host)
            ->setHttpClient(GuzzleAdapter::createWithConfig([
                Options::CONNECT_TIMEOUT => self::CONNECT_TIMEOUT,
                Options::TIMEOUT => self::TIMEOUT,
            ]));

        return new self($configurator);
    }

    public function getRealTimeData(): RealTime
    {
        $response = $this->call(self::ENDPOINT_REALTIME);

        return $this->hydrateResponse($response, RealTime::class);
    }

    public function getHistoryData(): History
    {
        $response = $this->call(self::ENDPOINT_HISTORY);

        return $this->hydrateResponse($response, History::class);
    }

    protected function call($path): ResponseInterface
    {
        try {
            $response = $this->client->sendRequest(
                $this->requestFactory->createRequest('GET', sprintf('/%s', $path))
            );
        } catch (NetworkException $e) {
            throw HttpServerException::networkError($e);
        }

        return $this->lastResponse = $response;
    }

    protected function hydrateResponse(ResponseInterface $response, string $class)
    {
        if ($response->getStatusCode() !== 200) {
            $this->handleErrors($response);
        }

        return call_user_func($class . '::create', $this->parseResponse($response));
    }

    /**
     *
     * @param ResponseInterface $response
     * @return array
     */
    protected function parseResponse(ResponseInterface $response): array
    {
        $emptyArrayValuesPattern = "/(,)(?=[,\]])/"; //Fix invalid json
        $json = preg_replace($emptyArrayValuesPattern, ',""', $response->getBody()->getContents());

        if (PREG_NO_ERROR !== preg_last_error()) {
            throw new \RuntimeException('Error (%d) when trying to preg_replace response', preg_last_error());
        }
        $data = json_decode((string) $json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(sprintf('Error (%d) when trying to json_decode response', json_last_error()));
        }

        return $data;
    }

    /**
     * @throws \Exception
     */
    protected function handleErrors(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        switch ($statusCode) {
            case 500 <= $statusCode:
                throw HttpServerException::serverError($statusCode);
            default:
                throw new UnknownErrorException();
        }
    }

    public function getLastResponse(): ResponseInterface
    {
        return $this->lastResponse;
    }
}
