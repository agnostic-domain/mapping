<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Repository;

use ADM\UseCase\Domain\Entity\Group as Aggregate;
use ADM\UseCase\Domain\Exception\Repository\NotFound;
use ADM\UseCase\Domain\Value\Id;

interface Group
{
    /**
     * @throws NotFound
     */
    public function get(Id $id): Aggregate;

    public function add(Aggregate $aggregate): void;
}
