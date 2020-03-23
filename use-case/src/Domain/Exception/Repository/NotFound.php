<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Exception\Repository;

use ADM\UseCase\Domain\Exception\Checked;

final class NotFound extends Checked
{
    public static function self(string $id): self
    {
        return new self("Aggregate with $id was not found");
    }
}
