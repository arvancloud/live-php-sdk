<?php
declare(strict_types=1);

namespace AR\LiveSdk\Utils;

use AR\LiveSdk\Exceptions\JsonDecodeException;
use AR\LiveSdk\Exceptions\JsonEncodeException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Response
 * @package AR\LiveSdk\Utils
 *
 * Response helper class
 */
final class Response
{
    /**
     * @var ResponseInterface
     */
    private $response;
    /**
     * @var int
     */
    private $successStatusCode;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     * @param int $successStatusCode
     */
    public function __construct(ResponseInterface $response, $successStatusCode = 200)
    {
        $this->response = $response;
        $this->successStatusCode = $successStatusCode;
    }

    /**
     * @param ResponseInterface $response
     * @param int $successStatusCode
     * @return static
     */
    public static function create(ResponseInterface $response, $successStatusCode = 200)
    {
        return new static($response, $successStatusCode);
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return array
     * @throws JsonDecodeException
     */
    public function getResult()
    {
        return Json::decode($this->response->getBody()->getContents());
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return (int)$this->response->getStatusCode();
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name Case-insensitive header field name.
     * @return string[] An array of string values as provided for the given
     *    header. If the header does not appear in the message, this method MUST
     *    return an empty array.
     */
    public function getHeader(string $name): array
    {
        return $this->response->getHeader($name);
    }

    /**
     * @return array
     * @throws JsonDecodeException
     */
    public function toArray(): array
    {
        return [
            'success' => (bool)($this->getStatusCode() === $this->successStatusCode),
            'result' => $this->getResult(),
            'status_code' => $this->getStatusCode(),
            'headers' => $this->getHeaders()
        ];
    }

    /**
     * @return string json
     * @throws JsonDecodeException
     * @throws JsonEncodeException
     */
    public function __toString()
    {
        return Json::encode($this->toArray());
    }
}
