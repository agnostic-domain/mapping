<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use PHPUnit\Framework\TestCase;
use ADM;

final class Extractor extends TestCase
{
    public function testExtracting(): void
    {
        $object = new class() {
            private int $property;

            public function setProperty(int $value): void
            {
                $this->property = $value;
            }
        };

        $object->setProperty(1);

        $this->assertSame(1, (new ADM\Extractor($object))->property());
    }
}
