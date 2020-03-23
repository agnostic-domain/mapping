<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Exception;

use Throwable;
use RuntimeException;

final class Unchecked extends RuntimeException
{
    public static function recast(Throwable $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
