<?php
declare(strict_types=1);

namespace AR\LiveSdk\API;

use AR\LiveSdk\Client;

abstract class API
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
