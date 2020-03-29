<?php

declare(strict_types=1);

namespace ADM;

use ADM\Exception\Unchecked;
use Closure;
use Generator;
use ReflectionClass;
use Throwable;

/**
 * @template T of object
 */
final class Hydrator
{
    private object $object;
    /** @var ReflectionClass<T> */
    private ReflectionClass $reflection;

    /**
     * @param class-string<T> $class
     */
    public function __construct(string $class)
    {
        try {
            $this->reflection = new ReflectionClass($class);
            $this->object = $this->reflection->newInstanceWithoutConstructor();
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    /**
     * @param array<int, mixed> $arguments
     *
     * @return self<T>
     */
    public function __call(string $propertyName, array $arguments): self
    {
        try {
            $value = $arguments[0];
            if ($value instanceof Closure) {
                $value = $this->evaluateValue($value);
            }

            $property = $this->reflection->getProperty($propertyName);
            $property->setAccessible(true);
            $property->setValue($this->object, $value);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }

        return $this;
    }

    /**
     * @param mixed $data
     */
    public function __invoke($data = null): object
    {
        if ($data) {
            Helper::$data[spl_object_id($this->object)] = $data;
        }

        return $this->object;
    }

    /**
     * @return mixed
     */
    private function evaluateValue(Closure $closure)
    {
        $value = $closure();

        if ($value instanceof Generator) {
            foreach ($value as $key => $item) {
                $values[$key] = $item;
            }
        }

        return $values ?? $value;
    }
}
