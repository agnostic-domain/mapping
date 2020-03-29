<?php

declare(strict_types=1);

use ADM\Exception\Unchecked\InvalidAdmArgument;
use ADM\Extractor;
use ADM\Helper;
use ADM\Hydrator;

/**
 * @param object|string|null $argument
 *
 * @return Extractor|Hydrator|Helper
 */
function adm($argument = null): object
{
    if (is_null($argument)) {
        return new Helper();
    }

    if (is_string($argument)) {
        return new Hydrator($argument);
    }

    if (is_object($argument)) {
        return new Extractor($argument);
    }

    throw InvalidAdmArgument::self();
}
