<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Exception;

use RuntimeException;
use Throwable;

class Unchecked extends RuntimeException
{
    final public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    final public static function recast(Throwable $exception): Unchecked
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }
}
