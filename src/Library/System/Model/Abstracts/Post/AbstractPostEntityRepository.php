<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;

abstract class AbstractPostEntityRepository
{
    protected PostEntityManagerInterface $manager;

    public function __construct(PostEntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function delete(int $pageId): void
    {
        $this->manager->delete($pageId);
    }

    public function trash(int $pageId): void
    {
        $this->manager->trash($pageId);
    }

    public function recover(int $pageId): void
    {
        $this->manager->recover($pageId);
    }
}
