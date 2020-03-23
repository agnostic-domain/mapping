<?php

declare(strict_types=1);

namespace ADM\UseCase\Domain\Entity\Group;

use ADM\UseCase\Domain\Value\Id;
use ADM\UseCase\Domain\Value\Email;

final class User
{
    private Id $id;
    private Email $email;

    public function __construct(Email $email)
    {
        $this->id = new Id();
        $this->email = $email;
    }

    public function id(): Id
    {
        return $this->id;
    }
}
