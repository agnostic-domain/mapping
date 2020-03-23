<?php

declare(strict_types=1);

namespace ADM\Mapping;

use Closure;
use Generator;
use Throwable;
use ADM\Exception;

final class Mapper
{
    /** @var mixed */
    private $class;
    /** @var mixed[] */
    private array $values = [];

    /**
     * @param mixed $class
     */
    public function __construct($class = null)
    {
        $this->class = $class;
    }

    /**
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $property, array $arguments)
    {
        if (empty($arguments)) {
            return (new Reflector($this->class))->get($property);
        }

        $this->values[$property] = $arguments[0];

        return $this;
    }

    /**
     * @param mixed $dtos
     */
    public function __invoke($dtos = null): object
    {
        try {
            $object = new Reflector($this->class);

            foreach ($this->values as $property => $value) {
                if ($value instanceof Closure) {
                    $value = $this->evaluate($value);
                }

                $object->set($property, $value);
            }
        } catch (Throwable $exception) {
            throw Exception\Unchecked::recast($exception);
        }

        $entity = $object();

        if ($dtos) {
            Helper::$dtos[spl_object_id($entity)] = $dtos;
        }

        return $entity;
    }

    /**
     * @return mixed
     */
    private function evaluate(Closure $closure)
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
