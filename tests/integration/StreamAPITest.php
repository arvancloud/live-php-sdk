<?php

namespace Test\integration;


use AR\LiveSdk\Client;
use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Exceptions\JsonDecodeException;
use Test\TestCase;

class StreamAPITest extends TestCase
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @var string
     */
    public $ignoreStreamId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['api_key' => env("API_KEY")]);
        $this->ignoreStreamId = env('IGNORE_STREAM_ID');
    }

    /**
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testStoreANewlyCreatedStream()
    {
        $api = $this->client->streamApi();
        $params = [
            'title' => 'integration test created',
            'description' => 'description created',
            'type' => 'normal',
            'mode' => 'push',
            'slug' => 'slug1',
            'fps' => 25,
            'convert_info' => [
                [
                    'audio_bitrate' => 320,
                    'video_bitrate' => 1500,
                    'resolution_width' => 1024,
                    'resolution_height' => 768,
                ]
            ],
        ];
        $res = $api->create($params);
        $this->assertIsArray($res->toArray());
    }

    /**
     * @return array
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testReturnAllStreams()
    {
        $api = $this->client->streamApi();
        $res = $api->getAll();
        $result = $res->toArray();
        $this->assertArrayHasKey('result', $result);
        return $result;
    }


    /**
     * @depends testReturnAllStreams
     * @param array $result
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testUpdateTheSpecifiedStream(array $result)
    {
        $api = $this->client->streamApi();
        $params = [
            'title' => 'integration test updated',
            'description' => 'description test',
            'fps' => 25,
            'convert_info' => [
                [
                    'audio_bitrate' => 128,
                    'video_bitrate' => 1800,
                    'resolution_width' => 1024,
                    'resolution_height' => 768,
                ]
            ],
        ];
        $streamId = $this->getStreamIdFromResult($result);
        $res = $api->update($streamId, $params);
        $this->assertIsArray($res->toArray());
    }

    /**
     * @depends testReturnAllStreams
     * @param array $result
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testReturnTheSpecifiedStream(array $result)
    {
        $api = $this->client->streamApi();
        $streamId = $this->getStreamIdFromResult($result);
        $res = $api->get($streamId);
        $this->assertIsArray($res->toArray());
    }

    /**
     * @depends testReturnAllStreams
     * @param array $result
     * @throws ApiFailedException
     * @throws JsonDecodeException
     */
    public function testRemoveTheSpecifiedStream(array $result)
    {
        $api = $this->client->streamApi();
        $streamId = $this->getStreamIdFromResult($result);
        $res = $api->delete($streamId);
        $this->assertArrayHasKey('result', $res->toArray());
    }

    /**
     * @param array $result
     * @return string
     */
    public function getStreamIdFromResult(array $result)
    {
        $streamId = $result['result']['data'][0]['id'] ?? "";
        if ($streamId == $this->ignoreStreamId)
            $streamId = $result['result']['data'][1]['id'] ?? "";
        return $streamId;
    }
}