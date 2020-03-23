<?php

declare(strict_types=1);

namespace ADM\Mapping;

final class Helper
{
    /** @var mixed[] */
    public static array $dtos = [];

    /**
     * @return mixed
     */
    public function data(object $object)
    {
        return self::$dtos[spl_object_id($object)];
    }

    /**
     * @param mixed[] $dtos
     * @param mixed[] $entities
     */
    public function collection(array $dtos, array $entities): CollectionHelper
    {
        return new CollectionHelper($this, $dtos, $entities);
    }
}
