<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Locator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class Gateway
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(string $data): ObjectRepository
    {
        return $this->entityManager->getRepository($data);
    }
}
