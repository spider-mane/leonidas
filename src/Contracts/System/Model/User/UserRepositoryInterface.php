<?php

namespace Leonidas\Contracts\System\Model\User;

interface UserRepositoryInterface
{
    public function get(int $id): UserInterface;

    public function getBySlug(string $slug): UserInterface;

    public function getByEmail(string $email): UserInterface;

    public function getByLogin(string $login): UserInterface;

    public function insert(UserInterface $user): void;

    public function update(UserInterface $user): void;

    public function delete(UserInterface $user): void;

    public function save(UserInterface $user): void;

    public function has(string $username): bool;

    public function persist(): void;
}
