<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use Leonidas\Contracts\System\Schema\Comment\CommentEntityManagerInterface;

abstract class AbstractCommentModelRepositoryInterface
{
    protected CommentEntityManagerInterface $manager;

    public function __construct(CommentEntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function delete(int $id): void
    {
        $this->manager->delete($id);
    }
}
