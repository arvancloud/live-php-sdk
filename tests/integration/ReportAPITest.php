<?php

namespace Test\integration;


use AR\LiveSdk\Client;
use AR\LiveSdk\Exceptions\ApiFailedException;
use Test\TestCase;
use Psr\Http\Message\ResponseInterface;

class ReportAPITest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['api_key' => env("API_KEY")]);
    }

    /**
     * @throws ApiFailedException
     */
    public function testReturnDomainStatisticsReport()
    {
        $api = $this->client->reportApi();
        $res = $api->getDomainStatisticsReport();
        $result = $res->toArray();
        $this->assertArrayHasKey('result', $result);
    }

    /**
     * @throws ApiFailedException
     */
    public function testReturnDomainTraffic()
    {
        $api = $this->client->reportApi();
        $res = $api->getDomainTraffic('1h');
        $result = $res->toArray();
        $this->assertArrayHasKey('result', $result);
    }

    /**
     * @throws ApiFailedException
     */
    public function testReturnUserAgent()
    {
        $api = $this->client->reportApi();
        $res = $api->getUserAgent('1h');
        $result = $res->toArray();
        $this->assertArrayHasKey('result', $result);
    }

    /**
     * @throws ApiFailedException
     */
    public function testReturnUserVisitors()
    {
        $api = $this->client->reportApi();
        $res = $api->getUserVisitors('1h');
        $result = $res->toArray();
        $this->assertArrayHasKey('result', $result);
    }

    public function testGetResponseContract()
    {
        $api = $this->client->reportApi();
        $res = $api->getUserVisitors('1h');
        $result = $res->getHttpResponse();
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testGetSpecificHeaderName()
    {
        $api = $this->client->reportApi();
        $res = $api->getUserVisitors('1h');
        $this->assertIsArray($res->getHeader('Content-Type'));
    }

    public function testGetResponseAsJsonString()
    {
        $api = $this->client->reportApi();
        $res = $api->getUserVisitors('1h');
        $this->assertJson((string)$res);
    }
}