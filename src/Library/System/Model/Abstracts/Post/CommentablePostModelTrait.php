<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use WP_Post;

trait CommentablePostModelTrait
{
    protected WP_Post $post;

    protected CommentRepositoryInterface $commentRepository;

    public function getCommentStatus(): string
    {
        return $this->post->comment_status;
    }

    public function getCommentCount(): int
    {
        return (int) $this->post->comment_count;
    }

    public function getComments(): CommentCollectionInterface
    {
        return $this->commentRepository->wherePost($this);
    }
}
