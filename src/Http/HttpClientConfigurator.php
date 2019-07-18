<?php

declare(strict_types=1);

namespace MStroink\Solax\Http;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\UriFactory;

final class HttpClientConfigurator implements ClientConfiguratorInterface
{
    const USERNAME = 'admin';
    const PASSWORD = 'admin';

    private $username = self::USERNAME;
    private $password = self::PASSWORD;
    private $host;

    /**
     * @var UriFactory
     */
    private $uriFactory;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function createConfiguredClient(): HttpClient
    {
        $plugins = [
            new Plugin\BaseUriPlugin(
                $this->getUriFactory()->createUri(sprintf('http://%s/api/', $this->host))
            ),
            new Plugin\HeaderDefaultsPlugin([
                'Authorization' => 'Basic ' . base64_encode(
                    sprintf('%s:%s', $this->username, $this->password)
                ),
            ]),
        ];

        return new PluginClient($this->getHttpClient(), $plugins);
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    private function getHttpClient(): HttpClient
    {
        if (null === $this->httpClient) {
            $this->httpClient = HttpClientDiscovery::find();
        }

        return $this->httpClient;
    }

    public function setHttpClient(HttpClient $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    private function getUriFactory(): UriFactory
    {
        if (null === $this->uriFactory) {
            $this->uriFactory = UriFactoryDiscovery::find();
        }

        return $this->uriFactory;
    }

    public function setUriFactory(UriFactory $uriFactory): self
    {
        $this->uriFactory = $uriFactory;

        return $this;
    }
}
