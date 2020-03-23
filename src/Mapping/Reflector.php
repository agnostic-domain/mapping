<?php

declare(strict_types=1);

namespace ADM\Mapping;

use Throwable;
use ADM\Exception;
use ReflectionClass as Reflection;

final class Reflector
{
    private object $object;

    /**
     * @template T of object
     * @phpstan-var Reflection<T>
     */
    private Reflection $reflection;

    /**
     * @template T
     * @phpstan-param T $class
     */
    public function __construct($class)
    {
        try {
            $this->reflection = new Reflection($class);
            if (is_object($class)) {
                $this->object = $class;
            } else {
                $this->object = $this->reflection->newInstanceWithoutConstructor();
            }
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }
    }

    /**
     * @return mixed
     */
    public function get(string $propertyName)
    {
        try {
            $property = $this->reflection->getProperty($propertyName);
            $property->setAccessible(true);

            return $property->getValue($this->object);
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }
    }

    /**
     * @param mixed $value
     */
    public function set(string $propertyName, $value): self
    {
        try {
            $property = $this->reflection->getProperty($propertyName);
            $property->setAccessible(true);
            $property->setValue($this->object, $value);
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }

        return $this;
    }

    public function __invoke(): object
    {
        return $this->object;
    }
}
