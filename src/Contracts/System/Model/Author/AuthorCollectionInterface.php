<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface AuthorCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): ?AuthorInterface;

    public function getByEmail(string $email): ?AuthorInterface;

    public function getByLogin(string $login): ?AuthorInterface;

    public function getByNicename(string $nicename): ?AuthorInterface;

    public function hasWithId(int $id): bool;

    public function hasWithLogin(string $login): bool;

    public function hasWithEmail(string $email): bool;

    public function add(AuthorInterface $user): void;

    public function collect(AuthorInterface ...$users): void;
}
