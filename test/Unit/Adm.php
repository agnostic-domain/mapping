<?php

declare(strict_types=1);

namespace ADM\Test\Unit;

use ADM\Exception;
use ADM\Mapping\Helper;
use ADM\Mapping\Mapper;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

final class Adm extends TestCase
{
    public function testCreatingMapper(): void
    {
        try {
            $this->assertInstanceOf(Mapper::class, adm(stdClass::class));
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }
    }

    public function testCreatingHelper(): void
    {
        try {
            $this->assertInstanceOf(Helper::class, adm());
            $this->assertInstanceOf(Helper::class, adm(null));
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }
    }
}
