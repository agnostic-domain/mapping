<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Entity;

use ADM\UseCase\Domain\Value\Id;
use ADM\UseCase\Domain\Entity\Group\User;

final class Group
{
    private Id $id;
    /** @var array<string, User> */
    private array $users = [];

    public function __construct()
    {
        $this->id = new Id();
    }

    public function add(User $user): void
    {
        $this->users[(string) $user->id()] = $user;
    }

    public function remove(Id $userId): void
    {
        unset($this->users[(string) $userId]);
    }
}
