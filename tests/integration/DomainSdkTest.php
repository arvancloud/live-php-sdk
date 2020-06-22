<?php


namespace Test\integration;


use AR\LiveSdk\Client;
use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Exceptions\ApiKeyNotFound;
use Test\TestCase;

class DomainSdkTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new Client(['api_key' => env("API_KEY")]);
    }

    public function testCreateFactory()
    {
        $this->assertInstanceOf(Client::class, $this->client);
    }

    public function testApiKeyNotSetInConfig()
    {
        $this->expectException(ApiKeyNotFound::class);
        Client::create([]);
    }

    public function testRequestApiHasFailed()
    {
        $this->expectException(ApiFailedException::class);
        $this->client->request('get', '/wrongurl', ['base_uri' => 'xyz']);
    }

    public function testWrongApiCall()
    {
        $this->expectException(\RuntimeException::class);
        $this->client->xyzApi();
    }

    public function testGetConfig()
    {
        $this->assertIsArray($this->client->getConfig());
    }
}