<?php
declare(strict_types=1);

namespace AR\LiveSdk;

use AR\LiveSdk\API\API;
use AR\LiveSdk\API\DomainApi;
use AR\LiveSdk\API\ReportApi;
use AR\LiveSdk\API\StreamApi;
use AR\LiveSdk\Exceptions\ApiFailedException;
use AR\LiveSdk\Exceptions\ApiKeyNotFound;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class Client
 * @package AR\LiveSdk
 * @method DomainApi domainApi()
 * @method StreamApi streamApi()
 * @method ReportApi reportApi()
 */
final class Client implements LiveSdkContract
{
    /**
     * @var array
     */
    private $config;
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Client constructor.
     *
     * @param array $config [
     *  'api_key'=> 'xyz',
     *  'lang' => 'en',
     *  'api_url'=> 'see https://www.arvancloud.com/fa/docs/api url'
     * ]
     *
     * @param array $overwriteGuzzleConfiguration
     * @throws ApiKeyNotFound
     */
    public function __construct(array $config, array $overwriteGuzzleConfiguration = [])
    {
        $this->config = $config;
        $this->validateConfig();
        $this->preparingConfig();
        $this->createDefaultHttpClient($overwriteGuzzleConfiguration);
    }

    /**
     * @param array $config
     * @return $this
     * @throws ApiKeyNotFound
     */
    public static function create(array $config)
    {
        return new static($config);
    }

    /**
     * @throws ApiKeyNotFound
     */
    private function validateConfig()
    {
        if (!isset($this->config['api_key'])) {
            throw new ApiKeyNotFound();
        }
    }

    private function preparingConfig()
    {
        $this->config['api_key'] = 'Apikey ' . str_replace('Apikey ', '', $this->config['api_key']);
        $this->config['lang'] = $this->config['lang'] ?? 'en';
        $this->config['api_url'] = $this->config['api_url'] ?? 'https://napi.arvancloud.com/live/2.0/';
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * preparing http client
     * @param array $guzzleConfiguration
     */
    private function createDefaultHttpClient(array $guzzleConfiguration = []): void
    {
        $this->httpClient = new HttpClient(array_merge([
            'base_uri' => $this->config['api_url'],
            'timeout' => 10,
            'http_errors' => false,
            'option' => ['http_errors' => false],
            'headers' => [
                'Authorization' => $this->config['api_key'],
                'Accept-Language' => $this->config['lang'],
                'Accept' => 'application/json',
            ]
        ], $guzzleConfiguration));
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Guzzle Request proxy
     *
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string $method HTTP method.
     * @param string|UriInterface $uri URI object or string.
     * @param array $options Request options to apply. See \GuzzleHttp\RequestOptions.
     *
     * @return ResponseInterface
     * @throws ApiFailedException
     */
    public function request($method, $uri = '', array $options = [])
    {
        try {
            return $this->getHttpClient()->request($method, $uri, $options);
        } catch (GuzzleException $exception) {
            throw new ApiFailedException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \ReflectionException if the class does not exist.
     */
    public function __call($name, $arguments)
    {
        $name = ucfirst($name);
        $apiNamespace = '\AR\LiveSdk\API\\' . $name;
        if (class_exists($apiNamespace)) {
            $refClass = new \ReflectionClass($apiNamespace);
            if ($refClass->isSubclassOf(API::class)) {
                return new $apiNamespace($this);
            }
        }
        throw new \RuntimeException("Method {$name} not exist.");
    }
}
