<?php

declare(strict_types=1);

namespace ADM\Test\Integration;

use ADM\Exception\Unchecked;
use ADM\UseCase\Application\Command\Handler\RemoveUserFromGroup as Handler;
use ADM\UseCase\Application\Command\RemoveUserFromGroup as Command;
use ADM\UseCase\Infrastructure\Data\User;
use ADM\UseCase\Infrastructure\Locator;
use ADM\UseCase\Infrastructure\Repository;
use Ramsey\Uuid\Uuid;
use Throwable;

final class RemoveUserFromGroup extends Test
{
    private Handler $handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->handler = new Handler(new Repository\Group(new Locator\Gateway(self::$doctrine)));
    }

    /**
     * @coversNothing
     */
    public function testExecutingCommand(): void
    {
        try {
            $groupId = Uuid::uuid4()->toString();

            $user1 = new User();
            $user1->id = Uuid::uuid4()->toString();
            $user1->email = 'user1@mail.com';
            $user1->groupId = $groupId;

            $user2 = new User();
            $user2->id = Uuid::uuid4()->toString();
            $user2->email = 'user2@mail.com';
            $user2->groupId = $groupId;

            self::$doctrine->persist($user1);
            self::$doctrine->persist($user2);
            self::$doctrine->flush();

            $this->handler->handle(new Command($user1->id, $user1->groupId));

            self::$doctrine->clear();

            $this->assertNull(self::$doctrine->find(User::class, $user1->id));
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }
}
