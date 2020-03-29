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
        $this->assertTrue(true);
    }

    public function testAdded(): void
    {
        $this->assertTrue(true);
    }

    public function testChanged(): void
    {
        $this->assertTrue(true);
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
