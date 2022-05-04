<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\UserCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Model\Abstracts\User\AbstractUserModelRepository;

class UserRepository extends AbstractUserModelRepository implements UserRepositoryInterface
{
    public function select(int $id): ?UserInterface
    {
        return $this->manager->select($id);
    }

    public function selectByNicename(string $slug): ?UserInterface
    {
        return $this->manager->selectByNicename($slug);
    }

    public function selectByEmail(string $email): ?UserInterface
    {
        return $this->manager->selectByEmail($email);
    }

    public function selectByLogin(string $login): ?UserInterface
    {
        return $this->manager->selectByLogin($login);
    }

    public function all(): UserCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(UserInterface $user): void
    {
        $this->manager->insert($this->extractData($user));
    }

    public function update(UserInterface $user): void
    {
        $this->manager->update($user->getId(), $this->extractData($user));
    }

    protected function extractData(UserInterface $user)
    {
        $dateFormat = UserEntityManagerInterface::DATE_FORMAT;
        $profile = $user->getProfile();

        return [
            'user_login' => $profile->getLogin(),
            'user_pass' => $profile->getPassword(),
            'user_nicename' => $profile->getNicename(),
            'user_email' => $profile->getEmail(),
            'user_url' => $profile->getUrl(),
            'user_registered' => $profile->getDateRegistered()->format($dateFormat),
            'user_activation_key' => $profile->getActivationKey(),
            'display_name' => $profile->getDisplayName(),
        ];
    }
}
