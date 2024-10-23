<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorCollectionInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Model\Abstracts\User\AbstractUserModelRepository;

class AuthorRepository extends AbstractUserModelRepository implements AuthorRepositoryInterface
{
    public function select(int $id): ?AuthorInterface
    {
        return $this->manager->byId($id);
    }

    public function selectNicename(string $slug): ?AuthorInterface
    {
        return $this->manager->byNicename($slug);
    }

    public function selectEmail(string $email): ?AuthorInterface
    {
        return $this->manager->byEmail($email);
    }

    public function selectLogin(string $login): ?AuthorInterface
    {
        return $this->manager->byLogin($login);
    }

    public function whereIds(int ...$ids): AuthorCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function all(): AuthorCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(AuthorInterface $author): void
    {
        $this->manager->insert($this->extractData($author));
    }

    public function update(AuthorInterface $author): void
    {
        $this->manager->update($author->getId(), $this->extractData($author));
    }

    protected function extractData(AuthorInterface $author)
    {
        $dateFormat = UserEntityManagerInterface::DATE_FORMAT;

        return [
            'user_login' => $author->getLogin(),
            'user_pass' => $author->getPassword(),
            'user_nicename' => $author->getNicename(),
            'user_email' => $author->getEmail(),
            'user_url' => $author->getUrl(),
            'user_registered' => $author->getDateRegistered()->format($dateFormat),
            'user_activation_key' => $author->getActivationKey(),
            'display_name' => $author->getDisplayName(),
            'use_ssl' => $author->useSsl(),
            'first_name' => $author->getFirstName(),
            'last_name' => $author->getLastName(),
            'description' => $author->getBio(),
            'nickname' => $author->getNickname(),
            'admin_color' => $author->getOption('admin_color'),
            'comment_shortcuts' => $author->getOption('comment_shortcuts'),
            'show_admin_bar_front' => $author->getOption('show_admin_bar_front'),
            'locale' => $author->getLocale(),
            'rich_editing' => $author->getOption('rich_editing'),
            'meta_input' => $this->extractMetadata($author),
        ];
    }

    protected function extractMetadata(AuthorInterface $author): array
    {
        return [];
    }
}
