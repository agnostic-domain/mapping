<?php

declare(strict_types=1);

namespace ADM\Exception\Unchecked;

use ADM\Exception\Unchecked;

final class InvalidAdmArgument extends Unchecked
{
    public static function self(): self
    {
        return new self('Function adm expects object, string or null as an argument');
    }
}
