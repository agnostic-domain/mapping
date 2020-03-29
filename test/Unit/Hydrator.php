<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use PHPUnit\Framework\TestCase;

final class Hydrator extends TestCase
{
    public function testHydrating(): void
    {
        $hydrator = new \ADM\Hydrator(Hydratee::class);
        $hydrator->integer(1);
        $hydrator->string(function() { return 'test'; });
        $object = $hydrator();

        $this->assertSame(1, $object->getInteger());
        $this->assertSame('test', $object->getString());
    }
}

class Hydratee
{
    private int $integer;
    private string $string;

    public function getInteger(): int
    {
        return $this->integer;
    }

    public function getString(): string
    {
        return $this->string;
    }
}
