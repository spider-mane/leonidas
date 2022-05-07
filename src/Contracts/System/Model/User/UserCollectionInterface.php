<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface UserCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): ?UserInterface;

    public function getByEmail(string $email): ?UserInterface;

    public function getByLogin(string $login): ?UserInterface;

    public function getByNicename(string $nicename): ?UserInterface;

    public function hasWithId(int $id): bool;

    public function hasWithLogin(string $login): bool;

    public function hasWithEmail(string $email): bool;

    public function add(UserInterface $user): void;

    public function collect(UserInterface ...$users): void;
}
