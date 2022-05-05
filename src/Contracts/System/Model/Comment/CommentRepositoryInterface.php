<?php

namespace Leonidas\Contracts\System\Model\Comment;

use Leonidas\Contracts\System\Model\FungibleRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

interface CommentRepositoryInterface extends FungibleRepositoryInterface
{
    public function select(int $id): ?CommentInterface;

    public function forPostApproved(PostInterface $post): CommentCollectionInterface;

    public function withParent(CommentInterface $comment): CommentCollectionInterface;

    public function withChild(CommentInterface $comment): CommentInterface;

    public function all(): CommentCollectionInterface;

    public function insert(CommentInterface $comment): void;

    public function update(CommentInterface $comment): void;
}
