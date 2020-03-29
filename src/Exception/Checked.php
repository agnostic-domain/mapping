<?php

declare(strict_types=1);

namespace ADM\Exception;

use LogicException;
use Throwable;

class Checked extends LogicException
{
    final public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    final public static function recast(Throwable $exception): Checked
    {
        return new static($exception->getMessage(), $exception->getCode(), $exception);
    }
}
