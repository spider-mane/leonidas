<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;

interface UserRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?UserInterface;

    public function selectNicename(string $slug): ?UserInterface;

    public function selectEmail(string $email): ?UserInterface;

    public function selectLogin(string $login): ?UserInterface;

    public function whereIds(int ...$ids): UserCollectionInterface;

    public function all(): UserCollectionInterface;

    public function insert(UserInterface $user): void;

    public function update(UserInterface $user): void;
}
