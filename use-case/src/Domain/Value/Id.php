<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Value;

use Throwable;
use Ramsey\Uuid\Uuid;
use ADM\UseCase\Domain\Exception\Value\Id as Exception;

final class Id
{
    private string $uuid;

    public function __construct(?string $uuid = null)
    {
        try {
            $this->uuid = $uuid ?? Uuid::uuid4()->toString();
        } catch (Throwable $exception) {
            throw Exception::couldNotGenerate($exception);
        }

        if (!Uuid::isValid($this->uuid)) {
            throw Exception::invalid($this->uuid);
        }
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
