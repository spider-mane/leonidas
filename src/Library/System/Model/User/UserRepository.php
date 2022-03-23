<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\UserCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserConverterInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected UserConverterInterface $converter;

    public function __construct(UserConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function get(int $id): UserInterface
    {
        return new User(get_user_by('id', $id));
    }

    public function getMany(int ...$ids): UserCollectionInterface
    {
        return array_map(fn (int $id) => $this->get($id), $ids);
    }

    public function getBySlug(string $slug): UserInterface
    {
        return new User(get_user_by('slug', $slug));
    }

    public function getByEmail(string $email): UserInterface
    {
        return new User(get_user_by('email', $email));
    }

    public function getByLogin(string $login): UserInterface
    {
        return new User(get_user_by('login', $login));
    }

    public function insert(UserInterface $user): void
    {
        wp_insert_user($this->converter->convert($user));
    }

    public function update(UserInterface $user): void
    {
        wp_update_user($this->converter->convert($user));
    }

    public function delete(UserInterface $user): void
    {
        wp_delete_user($user->getId());
    }

    public function save(UserInterface $user): void
    {
        if ($user->getId() && $this->has($user->getProfile()->getLogin())) {
            $this->update($user);
        } else {
            $this->insert($user);
        }
    }

    public function has(string $username): bool
    {
        return username_exists($username);
    }

    public function persist(): void
    {
        //
    }
}
