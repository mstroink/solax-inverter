<?php
declare(strict_types=1);

namespace MStroink\Solax\Exception;

use MStroink\Solax\Exception;

final class HttpServerException extends \RuntimeException implements Exception
{
    public static function serverError(int $httpStatus = 500)
    {
        return new self('An unexpected error occurred at the Solax Inverter.', $httpStatus);
    }

    public static function networkError(\Throwable $previous)
    {
        return new self('The Solax Inverter is currently unreachable.', 0, $previous);
    }

    public static function unknownHttpResponseCode(int $code)
    {
        return new self(sprintf('Unknown HTTP response code ("%d") received from the Solax Inverter', $code));
    }
}