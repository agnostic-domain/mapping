<?php

declare(strict_types=1);

use ADM\Mapping\Helper;
use ADM\Mapping\Mapper;

/**
 * @param mixed $class
 *
 * @return mixed
 */
function adm($class = null)
{
    if ($class === null) {
        return new Helper();
    }

    return new Mapper($class);
}
