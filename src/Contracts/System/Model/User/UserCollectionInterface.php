<?php

namespace Leonidas\Contracts\System\Model\User;

interface UserCollectionInterface
{
    public function get(int $id): UserInterface;

    public function getBySlug(string $slug): UserInterface;

    public function getByEmail(string $email): UserInterface;

    public function getByLogin(string $login): UserInterface;

    public function add(UserInterface $user): void;

    public function remove(int $id): void;

    public function has(string $username): bool;

    /**
     * @return UserInterface[]
     */
    public function all(): array;
}
