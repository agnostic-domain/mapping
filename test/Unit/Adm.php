<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use ADM\Exception\Unchecked;
use ADM\Helper;
use ADM\Hydrator;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

final class Adm extends TestCase
{
    public function testCreatingMapper(): void
    {
        try {
            $this->assertInstanceOf(Hydrator::class, adm(stdClass::class));
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    public function testCreatingHelper(): void
    {
        try {
            $this->assertInstanceOf(Helper::class, adm());
            $this->assertInstanceOf(Helper::class, adm(null));
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }
}
