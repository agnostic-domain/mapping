<?php

declare(strict_types=1);

namespace ADM\UseCase\Application\Command\Handler;

use ADM\UseCase\Application\Command\RemoveUserFromGroup as Command;
use ADM\UseCase\Domain\Exception\Repository\NotFound;
use ADM\UseCase\Domain\Repository;

final class RemoveUserFromGroup
{
    private Repository\Group $repository;

    public function __construct(Repository\Group $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Command $command): void
    {
        try {
            $group = $this->repository->get($command->groupId());
        } catch (NotFound $exception) {
            return;
        }

        $group->remove($command->userId());
        $this->repository->add($group);
    }
}
