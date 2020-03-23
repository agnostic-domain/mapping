<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Exception\Value;

use ADM\UseCase\Domain\Exception\Unchecked;

final class Email extends Unchecked
{
    public static function invalid(string $email): self
    {
        return new self("Email $email is invalid");
    }
}
