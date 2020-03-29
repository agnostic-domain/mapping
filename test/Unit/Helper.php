<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use ADM;
use PHPUnit\Framework\TestCase;
use stdClass;

final class Helper extends TestCase
{
    public function testRetrievingData(): void
    {
        $data = new stdClass();
        $entity = new stdClass();
        ADM\Helper::$data[spl_object_id($entity)] = $data;

        $this->assertSame($data, (new ADM\Helper())->data($entity));
    }

    public function testRetrievingData(): void
    {
        $data = new stdClass();
        $entity = new stdClass();
        ADM\Helper::$data[spl_object_id($entity)] = $data;

        $this->assertSame($data, (new ADM\Helper())->data($entity));
    }
}
