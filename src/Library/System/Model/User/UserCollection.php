<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\UserCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use WP_User;

class UserCollection extends AbstractModelCollection implements UserCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'login';

    public function __construct(WP_User ...$users)
    {
        $this->initKernel($users);
    }

    public function getById(int $id): UserInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByLogin(string $login): UserInterface
    {
        return $this->kernel->fetch($login);
    }

    public function getByEmail(string $email): UserInterface
    {
        return $this->kernel->firstWhere('email', '=', $email);
    }

    public function getBySlug(string $slug): UserInterface
    {
        return $this->kernel->firstWhere('slug', '=', $slug);
    }

    public function insert(UserInterface $user): void
    {
        $this->kernel->insert($user);
    }

    public function hasUser(string $login): bool
    {
        return $this->kernel->contains($login);
    }
}
