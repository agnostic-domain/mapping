<?php

declare(strict_types=1);

namespace ADM;

use ADM\Exception\Unchecked;
use ReflectionClass;
use Throwable;

/**
 * @template T of object
 */
final class Extractor
{
    private object $object;
    /** @var ReflectionClass<T> */
    private ReflectionClass $reflection;

    /**
     * @param T $object
     */
    public function __construct(object $object)
    {
        try {
            $this->object = $object;
            $this->reflection = new ReflectionClass($object);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    /**
     * @param array<int, mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $propertyName, array $arguments)
    {
        try {
            $property = $this->reflection->getProperty($propertyName);
            $property->setAccessible(true);

            return $property->getValue($this->object);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }
}
