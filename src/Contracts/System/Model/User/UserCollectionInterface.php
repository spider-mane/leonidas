<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface UserCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): UserInterface;

    public function getBySlug(string $slug): UserInterface;

    public function getByEmail(string $email): UserInterface;

    public function getByLogin(string $login): UserInterface;

    public function hasUser(string $login): bool;

    public function insert(UserInterface $user): void;
}
