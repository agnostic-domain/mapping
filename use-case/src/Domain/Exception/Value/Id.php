<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Exception\Value;

use Throwable;
use ADM\UseCase\Domain\Exception\Unchecked;

final class Id extends Unchecked
{
    public static function invalid(string $id): self
    {
        return new self("ID $id is invalid");
    }

    public static function couldNotGenerate(Throwable $exception): self
    {
        return new self('Could not generate id: ' . $exception->getMessage(), $exception->getCode(), $exception);
    }
}
