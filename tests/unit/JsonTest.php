<?php

namespace Test\unit;


use AR\LiveSdk\Exceptions\JsonDecodeException;
use AR\LiveSdk\Exceptions\JsonEncodeException;
use AR\LiveSdk\Utils\Json;
use Test\TestCase;

class JsonTest extends TestCase
{
    public function testEncodeArrayToJson()
    {
        $data = ["hello", "my", "age", "is", 30];
        $jsonString = Json::encode($data);
        $this->assertJson($jsonString);
    }

    public function testEncodeArrayToJsonFailure()
    {
        $data = ["hello", "my", "age", "is", "\xB1\x31"];
        $this->expectException(JsonEncodeException::class);
        Json::encode($data);
    }

    public function testDecodeJsonString()
    {
        $jsonString = '{"name":"arvan","name_1":"cloud","name_2":"service"}';
        $data = Json::decode($jsonString);
        $this->assertArrayHasKey('name', $data);
    }

    public function testDecodeJsonStringFailure()
    {
        $data = '{"hello","my","age","is","\xB1\x31"}';
        $this->expectException(JsonDecodeException::class);
        Json::decode($data);
    }
}