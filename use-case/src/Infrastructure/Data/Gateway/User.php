<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Data\Gateway;

use ADM\UseCase\Infrastructure\Data\User as Data;
use ADM\UseCase\Infrastructure\Exception\Unchecked;
use Doctrine\ORM\EntityRepository;
use Throwable;

final class User extends EntityRepository
{
    /**
     * @return array<string, Data>
     */
    public function getGroup(string $id): array
    {
        try {
            return $this->createQueryBuilder('user')
                ->where('user.groupId = :id')
                ->setParameter('id', $id)
                ->indexBy('user', 'user.id')
                ->getQuery()
                ->getResult();
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    public function save(Data $data): void
    {
        try {
            $this->getEntityManager()->persist($data);
            $this->getEntityManager()->flush($data);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    public function remove(Data $data): void
    {
        try {
            $this->getEntityManager()->remove($data);
            $this->getEntityManager()->flush($data);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }
}
