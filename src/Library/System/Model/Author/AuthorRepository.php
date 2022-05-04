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
        return $this->manager->select($id);
    }

    public function selectByNicename(string $slug): ?AuthorInterface
    {
        return $this->manager->selectByNicename($slug);
    }

    public function selectByEmail(string $email): ?AuthorInterface
    {
        return $this->manager->selectByEmail($email);
    }

    public function selectByLogin(string $login): ?AuthorInterface
    {
        return $this->manager->selectByLogin($login);
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
        ];
    }
}
