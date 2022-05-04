<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;

interface UserRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?UserInterface;

    public function selectByNicename(string $slug): ?UserInterface;

    public function selectByEmail(string $email): ?UserInterface;

    public function selectByLogin(string $login): ?UserInterface;

    public function all(): UserCollectionInterface;

    public function insert(UserInterface $user): void;

    public function update(UserInterface $user): void;
}
