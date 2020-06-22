<?php
declare(strict_types=1);

namespace AR\LiveSdk\Utils;

use AR\LiveSdk\Exceptions\JsonDecodeException;
use AR\LiveSdk\Exceptions\JsonEncodeException;

/**
 * Class Json
 * @package AR\LiveSdk\Utils
 *
 * Json helper class
 */
class Json
{
    /**
     * @param string $data
     * @return array
     * @throws JsonDecodeException
     */
    public static function decode(string $data): array
    {
        $arrayData = json_decode($data, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonDecodeException(json_last_error_msg());
        }
        return $arrayData;
    }

    /**
     * @param mixed $data
     * @return string
     * @throws JsonEncodeException
     */
    public static function encode($data): string
    {
        $jsonString = json_encode($data, 320);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonEncodeException(json_last_error_msg());
        }
        return $jsonString;
    }
}
