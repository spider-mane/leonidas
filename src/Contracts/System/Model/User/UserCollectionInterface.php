<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface UserCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): UserInterface;

    public function getBySlug(string $slug): UserInterface;

    public function getByEmail(string $email): UserInterface;

    public function getByLogin(string $login): UserInterface;

    public function add(UserInterface $user): void;

    public function hasUser(string $username): bool;

    public function remove(int $id): void;
}
