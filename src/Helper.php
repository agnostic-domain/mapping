<?php

declare(strict_types=1);

namespace ADM;

use ADM\Helper\CollectionHandler;

final class Helper
{
    /** @var array<int, mixed> */
    public static array $data = [];

    /**
     * @return mixed
     */
    public function data(object $entity)
    {
        return self::$data[spl_object_id($entity)];
    }

    /**
     * @param array<int|string, object> $data
     * @param array<int|string, object> $entities
     */
    public function collection(array $data, array $entities): CollectionHandler
    {
        return new CollectionHandler($this, $data, $entities);
    }
}
