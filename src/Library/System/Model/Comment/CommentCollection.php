<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class CommentCollection extends AbstractModelCollection implements CommentCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    protected const MODEL_IDENTIFIER = 'id';

    protected const COLLECTION_IS_MAP = true;

    public function __construct(CommentInterface ...$comments)
    {
        $this->initKernel($comments);
    }

    public function getById(int $id): CommentInterface
    {
        return $this->kernel->fetch($id);
    }

    public function add(CommentInterface $comment): void
    {
        $this->kernel->insert($comment);
    }

    public function collect(CommentInterface ...$comments): void
    {
        $this->kernel->collect($comments);
    }
}
