<?php

declare(strict_types=1);

namespace MStroink\Solax\Tests;

use MStroink\Solax\Inverter;
use MStroink\Solax\Http\ClientConfiguratorInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;
use MStroink\Solax\Exception\HttpServerException;
use MStroink\Solax\Resource\History\History;
use MStroink\Solax\Resource\RealTime\RealTime;

class InverterTest extends TestBase
{
    protected $realTimePayload;
    protected $historyPayload;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $httpClient;

    /**
     * @var \MStroink\Solax\Inverter
     */
    protected $inverter;

    public function setUp()
    {
        $this->httpClient = $this->getMockBuilder(HttpClient::class)->getMock();
        $httpClientConfigurator = $this->getMockBuilder(ClientConfiguratorInterface::class)->getMock();

        $httpClientConfigurator
            ->expects($this->once())
            ->method('createConfiguredClient')
            ->willReturn($this->httpClient);

        $this->inverter = new Inverter($httpClientConfigurator);
    }

    public function testCreate()
    {
        $inverter = Inverter::create('::1');
        $this->assertInstanceOf(Inverter::class, $inverter);
    }

    public function testGetRealTimeData()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->callback(function (Request $request) {
                    $this->assertSame($request->getMethod(), 'GET');
                    $this->assertSame($request->getUri()->getPath(), '/realTimeData.htm');
                    $this->assertInstanceOf(Request::class, $request);

                    return true;
                })
            )
            ->willReturn(new Response(200, [], $this->fixture('RawRealTimeData.txt', false)));

        $response = $this->inverter->getRealTimeData();

        $this->assertCount(5, $response->toArray());
        $this->assertInstanceOf(RealTime::class, $response);
    }

    public function testGetHistoryData()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->callback(function (Request $request) {
                    $this->assertSame($request->getMethod(), 'GET');
                    $this->assertSame($request->getUri()->getPath(), '/historyData.htm');
                    $this->assertInstanceOf(Request::class, $request);

                    return true;
                })
            )
            ->willReturn(new Response(200, [], $this->fixture('RawHistoryData.txt', false)));

        $response = $this->inverter->getHistoryData();
        $this->assertCount(2, $response->toArray());
        $this->assertInstanceOf(History::class, $response);
    }

    public function testGetRealTimeDataShouldThrowServerException()
    {
        $this->expectException(HttpServerException::class);

        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(500));

        $this->inverter->getRealTimeData();
    }
}
