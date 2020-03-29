<?php

declare(strict_types=1);

namespace ADM\Test\Integration;

use ADM\Exception\Unchecked;
use Doctrine\ORM\EntityManager as Doctrine;
use Doctrine\ORM\Tools\SchemaTool as Schema;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use Throwable;

abstract class Test extends TestCase
{
    private const CONNECTION = ['url' => 'sqlite:///:memory:'];
    private const MAPPING = [__DIR__ . '/../../use-case/config/doctrine'];

    protected static Doctrine $doctrine;
    protected static Schema $schema;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        try {
            self::$doctrine = Doctrine::create(self::CONNECTION, Setup::createXMLMetadataConfiguration(self::MAPPING));
            self::$schema = new Schema(self::$doctrine);
        } catch (Throwable $exception) {
            throw new Unchecked($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::$schema->dropDatabase();
        self::$schema->updateSchema(self::$doctrine->getMetadataFactory()->getAllMetadata());
    }
}
