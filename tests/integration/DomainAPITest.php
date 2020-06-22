<?php

namespace Test\integration;


use AR\LiveSdk\Client;
use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Exceptions\JsonDecodeException;
use Test\TestCase;

class DomainAPITest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['api_key' => env("API_KEY")]);
    }


    /**
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testGetUserDomain()
    {
        $api = $this->client->domainApi();
        $res = $api->getUserDomain();
        $this->assertIsArray($res->toArray());
    }

    /**
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testSetSubdomainForLIVEService()
    {
        $api = $this->client->domainApi();
        $res = $api->setSubdomainForLIVEService('test');
        $this->assertIsArray($res->toArray());
    }
}