<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Value;

use ADM\UseCase\Domain\Exception\Value\Email as Exception;

final class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw Exception::invalid($email);
        }

        $this->email = $email;
    }
}
