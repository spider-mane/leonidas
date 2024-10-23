<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use Leonidas\Contracts\System\Model\PostModelInterface;
use Leonidas\Contracts\System\Model\UserModelInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;

abstract class AbstractUserModelRepository
{
    protected UserEntityManagerInterface $manager;

    public function __construct(UserEntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function delete(int $id): void
    {
        $this->manager->delete($id);
    }

    protected function byPostModel(PostModelInterface $model): UserModelInterface
    {
        return $this->manager->byId((int) $model->getCore()->post_author);
    }
}
