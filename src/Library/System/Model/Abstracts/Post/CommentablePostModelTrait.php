<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use WP_Post;

trait CommentablePostModelTrait
{
    use LazyLoadableRelationshipsTrait;

    protected WP_Post $post;

    protected CommentCollectionInterface $comments;

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
        return $this->lazyLoadable('comments');
    }

    protected function getCommentsFromRepository(): CommentCollectionInterface
    {
        return $this->commentRepository->forPostAndApproved($this);
    }
}
