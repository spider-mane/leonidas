<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;

interface AuthorRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?AuthorInterface;

    public function selectNicename(string $slug): ?AuthorInterface;

    public function selectEmail(string $email): ?AuthorInterface;

    public function selectLogin(string $login): ?AuthorInterface;

    public function whereIds(int ...$ids): AuthorCollectionInterface;

    public function all(): AuthorCollectionInterface;

    public function insert(AuthorInterface $user): void;

    public function update(AuthorInterface $user): void;
}
