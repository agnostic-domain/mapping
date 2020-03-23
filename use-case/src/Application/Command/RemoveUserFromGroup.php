<?php

declare(strict_types=1);

namespace ADM\UseCase\Application\Command;

use ADM\UseCase\Domain\Value\Id;

final class RemoveUserFromGroup
{
    private Id $userId;
    private Id $groupId;

    public function __construct(string $userId, string $groupId)
    {
        $this->userId = new Id($userId);
        $this->groupId = new Id($groupId);
    }

    public function userId(): Id
    {
        return $this->userId;
    }

    public function groupId(): Id
    {
        return $this->groupId;
    }
}
