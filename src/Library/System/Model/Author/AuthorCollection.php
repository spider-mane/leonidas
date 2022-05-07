<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorCollectionInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use WP_User;

class AuthorCollection extends AbstractModelCollection implements AuthorCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'login';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(WP_User ...$users)
    {
        $this->initKernel($users);
    }

    public function getById(int $id): ?AuthorInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByLogin(string $login): ?AuthorInterface
    {
        return $this->kernel->fetch($login);
    }

    public function getByEmail(string $email): ?AuthorInterface
    {
        return $this->kernel->firstWhere('email', '=', $email);
    }

    public function getByNicename(string $nicename): ?AuthorInterface
    {
        return $this->kernel->firstWhere('nicename', '=', $nicename);
    }

    public function hasWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function hasWithLogin(string $login): bool
    {
        return $this->kernel->contains($login);
    }

    public function hasWithEmail(string $email): bool
    {
        return $this->kernel->hasWhere('email', '=', $email);
    }

    public function add(AuthorInterface $user): void
    {
        $this->kernel->insert($user);
    }

    public function collect(AuthorInterface ...$users): void
    {
        $this->kernel->collect($users);
    }
}
