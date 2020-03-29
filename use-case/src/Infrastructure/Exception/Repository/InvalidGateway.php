<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Exception\Repository;

use ADM\UseCase\Infrastructure\Exception\Unchecked;

final class InvalidGateway extends Unchecked
{
    public static function self(string $expectedGateway): self
    {
        return new self('Expected ' . $expectedGateway);
    }
}
