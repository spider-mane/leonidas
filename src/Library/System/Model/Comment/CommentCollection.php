<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;

class CommentCollection implements CommentCollectionInterface
{
    /**
     * @var CommentInterface[]
     */
    protected array $comments;

    public function __construct(CommentInterface ...$comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return CommentInterface[]
     */
    public function all(): array
    {
        return $this->comments;
    }
}
