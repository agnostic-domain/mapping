<?php

declare(strict_types=1);

namespace ADM\Test\Unit\Helper;

use ADM;
use PHPUnit\Framework\TestCase;
use stdClass;

final class CollectionHandler extends TestCase
{
    public function testRemoved(): void
    {
        $collectionHandler = new ADM\Helper\CollectionHandler(
            new ADM\Helper(),
            [1 => new Data(1), 2 => new Data(2)],
            [1 => new Entity(1)]
        );

        $collectionHandler->removed(function(Data $data): void {
            $this->assertSame(2, $data->id);
        });
    }

    public function testAdded(): void
    {
        $collectionHandler = new ADM\Helper\CollectionHandler(
            new ADM\Helper(),
            [1 => new Data(1)],
            [1 => new Entity(1), 2 => new Entity(2)]
        );

        $collectionHandler->added(function(Entity $entity): void {
            $this->assertSame(2, $entity->id);
        });
    }

    public function testChanged(): void
    {
        $collectionHandler = new ADM\Helper\CollectionHandler(
            new ADM\Helper(),
            [1 => new Data(1)],
            [1 => new Entity(1)]
        );

        $collectionHandler->changed(function(Data $data, Entity $entity): void {
            $this->assertSame(1, $data->id);
            $this->assertSame(1, $entity->id);
        });
    }

    public function testOtherCall(): void
    {
        $data = new stdClass();
        $entity = new stdClass();
        ADM\Helper::$data[spl_object_id($entity)] = $data;

        $collectionHandler = new ADM\Helper\CollectionHandler(new ADM\Helper(), [], []);
        $this->assertSame($data, $collectionHandler->data($entity));
    }
}

class Data
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}

class Entity
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
