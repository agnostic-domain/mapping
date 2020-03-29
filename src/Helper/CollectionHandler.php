<?php

declare(strict_types=1);

namespace ADM\Helper;

use ADM\Helper;
use Closure;

final class CollectionHandler
{
    private Helper $helper;
    /** @var array<int|string, object> */
    private array $data;
    /** @var array<int|string, object> */
    private array $entities;
    /** @var array<int|string, object> */
    private array $removed;
    /** @var array<int|string, object> */
    private array $added;
    /** @var array<int|string, object> */
    private array $changed;

    /**
     * @param array<int|string, object> $data
     * @param array<int|string, object> $entities
     */
    public function __construct(Helper $helper, array $data, array $entities)
    {
        $this->helper = $helper;
        $this->data = $data;
        $this->entities = $entities;

        $this->removed = array_diff_key($this->data, $this->entities);
        $this->added = array_diff_key($this->entities, $this->data);
        $this->changed = array_diff_key($this->data, $this->removed);
    }

    public function removed(Closure $closure): self
    {
        foreach ($this->removed as $data) {
            $closure($data);
        }

        return $this;
    }

    public function added(Closure $closure): self
    {
        foreach ($this->added as $entity) {
            $closure($entity);
        }

        return $this;
    }

    public function changed(Closure $closure): self
    {
        foreach ($this->changed as $id => $data) {
            $closure($data, $this->entities[$id]);
        }

        return $this;
    }

    /**
     * @param array<int, mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->helper->$name(...$arguments);
    }
}
