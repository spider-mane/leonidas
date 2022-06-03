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

    public function selectNicename(string $slug): ?UserInterface
    {
        return $this->manager->selectNicename($slug);
    }

    public function selectEmail(string $email): ?UserInterface
    {
        return $this->manager->selectEmail($email);
    }

    public function selectLogin(string $login): ?UserInterface
    {
        return $this->manager->selectLogin($login);
    }

    public function whereIds(int ...$ids): UserCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
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

        return [
            'user_login' => $user->getLogin(),
            'user_pass' => $user->getPassword(),
            'user_nicename' => $user->getNicename(),
            'user_email' => $user->getEmail(),
            'user_url' => $user->getUrl(),
            'user_registered' => $user->getDateRegistered()->format($dateFormat),
            'user_activation_key' => $user->getActivationKey(),
            'display_name' => $user->getDisplayName(),
            'use_ssl' => $user->useSsl(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'description' => $user->getBio(),
            'nickname' => $user->getNickname(),
            'admin_color' => $user->getOption('admin_color'),
            'comment_shortcuts' => $user->getOption('comment_shortcuts'),
            'show_admin_bar_front' => $user->getOption('show_admin_bar_front'),
            'locale' => $user->getLocale(),
            'rich_editing' => $user->getOption('rich_editing'),
            'meta_input' => $this->extractMetadata($user),
        ];
    }

    protected function extractMetadata(UserInterface $user): array
    {
        return [];
    }
}
