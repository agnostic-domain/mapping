<?php

declare(strict_types=1);

namespace ADM\UseCase\Infrastructure\Repository;

use ADM\UseCase\Domain\Entity\Group as Aggregate;
use ADM\UseCase\Domain\Exception\Repository\NotFound;
use ADM\UseCase\Domain\Repository\Group as Port;
use ADM\UseCase\Domain\Value\Email;
use ADM\UseCase\Domain\Value\Id;
use ADM\UseCase\Infrastructure\Data;
use ADM\UseCase\Infrastructure\Exception\Repository\InvalidGateway;
use ADM\UseCase\Infrastructure\Locator;

final class Group implements Port
{
    private Data\Gateway\User $userGateway;

    public function __construct(Locator\Gateway $gatewayLocator)
    {
        $userGateway = $gatewayLocator->get(Data\User::class);
        if (!$userGateway instanceof Data\Gateway\User) {
            throw InvalidGateway::self(Data\Gateway\User::class);
        }

        $this->userGateway = $userGateway;
    }

    public function add(Aggregate $aggregate): void
    {
        adm()->collection(adm()->data($aggregate), adm($aggregate)->users())
            ->removed(function($data) { $this->userGateway->remove($data); })
            ->added(function($data) { $this->userGateway->save($data); })
            ->changed(function(Data\User $data, Aggregate\User $entity) {
                $data->id = adm(adm($entity)->id())->uuid();
                $data->email = adm(adm($entity)->email())->email();
                $this->userGateway->save($data);
            });
    }

    public function get(Id $id): Aggregate
    {
        $data = $this->userGateway->getGroup(adm($id)->uuid());

        if (!$data) {
            throw NotFound::self(adm($id)->uuid());
        }

        return adm(Aggregate::class)
            ->id(adm(Id::class)->uuid(reset($data)->groupId)())
            ->users(array_map(fn($data) => $this->user($data), $data))($data);
    }

    private function user(Data\User $data): Aggregate\User
    {
        return adm(Aggregate\User::class)
            ->id(adm(Id::class)->uuid($data->id)())
            ->email(adm(Email::class)->email($data->email)())();
    }
}
