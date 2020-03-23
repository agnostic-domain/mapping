<?php

declare(strict_types=1);

namespace ADM\Mapping;

use Closure;

final class CollectionHelper
{
    private Helper $helper;
    /** @var mixed[] */
    private array $dtos;
    /** @var mixed[] */
    private array $entities;
    /** @var mixed[] */
    private array $removed;
    /** @var mixed[] */
    private array $added;
    /** @var mixed[] */
    private array $changed;

    /**
     * @param mixed[] $dtos
     * @param mixed[] $entities
     */
    public function __construct(Helper $helper, array $dtos, array $entities)
    {
        $this->helper = $helper;
        $this->dtos = $dtos;
        $this->entities = $entities;

        $this->removed = array_diff_key($dtos, $entities);
        $this->added = array_diff_key($entities, $dtos);
        $this->changed = array_diff_key($dtos, $this->removed);
    }

    public function removed(Closure $closure): self
    {
        foreach ($this->removed as $dto) {
            $closure($dto);
        }

        return $this;
    }

    public function added(Closure $closure): self
    {
        foreach ($this->added as $dto) {
            $closure($dto);
        }

        return $this;
    }

    public function changed(Closure $closure): self
    {
        foreach ($this->changed as $id => $dto) {
            $closure($dto, $this->entities[$id]);
        }

        return $this;
    }

    /**
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->helper->$name(...$arguments);
    }
}
