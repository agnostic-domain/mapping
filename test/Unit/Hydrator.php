<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use ADM;
use PHPUnit\Framework\TestCase;
use stdClass;

final class Hydrator extends TestCase
{
    public function testHydrating(): void
    {
        $hydrator = new ADM\Hydrator(Hydratee::class);
        $hydrator->integer(1);
        $hydrator->string(function() { return 'test'; });
        $hydrator->array(function() {
            foreach ([1, 2] as $integer) {
                yield $integer;
            }
        });
        $object = $hydrator(new stdClass());

        $this->assertSame(1, $object->getInteger());
        $this->assertSame('test', $object->getString());
        $this->assertSame([1, 2], $object->getArray());
    }
}

class Hydratee
{
    private int $integer;
    private string $string;
    /** @var array<int, int> */
    private array $array;

    public function getInteger(): int
    {
        return $this->integer;
    }

    public function getString(): string
    {
        return $this->string;
    }

    /**
     * @return array<int, int>
     */
    public function getArray(): array
    {
        return $this->array;
    }
}
