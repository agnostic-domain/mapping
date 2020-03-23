<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Repository;

use ADM\UseCase\Domain;
use ADM\UseCase\Domain\Entity\Group as Aggregate;
use ADM\UseCase\Domain\Exception\Repository\NotFound;
use ADM\UseCase\Domain\Value\Email;
use ADM\UseCase\Domain\Value\Id;
use ADM\UseCase\Infrastructure\Data;
use ADM\UseCase\Infrastructure\Exception\Unchecked;
use ADM\UseCase\Infrastructure\Locator;

final class Group implements Domain\Repository\Group
{
    private Data\Gateway\User $userGateway;

    public function __construct(Locator\Gateway $gatewayLocator)
    {
        $userGateway = $gatewayLocator->get(Data\User::class);
        if (!$userGateway instanceof Data\Gateway\User) {
            throw new Unchecked('Expected ' . Data\Gateway\User::class);
        }

        $this->userGateway = $userGateway;
    }

    public function add(Aggregate $aggregate): void
    {
        adm()->collection(adm()->data($aggregate), adm($aggregate)->users())
            ->removed(function($dto) { $this->userGateway->remove($dto); })
            ->added(function($dto) { $this->userGateway->save($dto); })
            ->changed(function(Data\User $dto, Aggregate\User $entity) {
                $dto->id = adm(adm($entity)->id())->uuid();
                $dto->email = adm(adm($entity)->email())->email();
            });
    }

    public function get(Id $id): Aggregate
    {
        $dtos = $this->userGateway->getGroup(adm($id)->uuid());

        if (!$dtos) {
            throw NotFound::self(adm($id)->uuid());
        }

        return adm(Aggregate::class)
            ->id(adm(Id::class)->uuid(reset($dtos)->groupId)())
            ->users(array_map(fn($dto) => $this->user($dto), $dtos))($dtos);
    }

    private function user(Data\User $dto): Aggregate\User
    {
        return adm(Aggregate\User::class)
            ->id(adm(Id::class)->uuid($dto->id)())
            ->email(adm(Email::class)->email($dto->email)())();
    }
}
