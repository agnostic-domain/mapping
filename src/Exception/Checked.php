<?php

declare(strict_types=1);

namespace ADM\Exception;

use LogicException;
use Throwable;

final class Checked extends LogicException
{
    public static function recast(Throwable $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
