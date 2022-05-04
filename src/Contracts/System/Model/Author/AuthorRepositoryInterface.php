<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;

interface AuthorRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?AuthorInterface;

    public function selectByNicename(string $slug): ?AuthorInterface;

    public function selectByEmail(string $email): ?AuthorInterface;

    public function selectByLogin(string $login): ?AuthorInterface;

    public function all(): AuthorCollectionInterface;

    public function insert(AuthorInterface $user): void;

    public function update(AuthorInterface $user): void;
}
