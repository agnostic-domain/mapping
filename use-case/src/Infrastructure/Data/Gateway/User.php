<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Data\Gateway;

use ADM\UseCase\Infrastructure\Data\User as Dto;
use ADM\UseCase\Infrastructure\Exception\Unchecked;
use Doctrine\ORM\EntityRepository;
use Throwable;

final class User extends EntityRepository
{
    /**
     * @return Dto[]
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

    public function save(Dto $dto): void
    {
        try {
            $this->getEntityManager()->persist($dto);
            $this->getEntityManager()->flush($dto);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }

    public function remove(Dto $dto): void
    {
        try {
            $this->getEntityManager()->remove($dto);
            $this->getEntityManager()->flush($dto);
        } catch (Throwable $exception) {
            throw Unchecked::recast($exception);
        }
    }
}
