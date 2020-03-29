<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use ADM\Exception\Unchecked\InvalidAdmArgument;
use ADM\Extractor;
use ADM\Helper;
use ADM\Hydrator;
use PHPUnit\Framework\TestCase;
use stdClass;

final class Adm extends TestCase
{
    public function testCreatingHelper(): void
    {
        $this->assertInstanceOf(Helper::class, adm());
        $this->assertInstanceOf(Helper::class, adm(null));
    }

    public function testCreatingExtractor(): void
    {
        $this->assertInstanceOf(Extractor::class, adm(new stdClass()));
    }

    public function testCreatingHydrator(): void
    {
        $this->assertInstanceOf(Hydrator::class, adm(self::class));
    }

    public function testInvalidCall(): void
    {
        $this->expectException(InvalidAdmArgument::class);
        adm(1);
    }
}
