<?php

namespace Leonidas\Library\System\Model\Comment;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use WP_Comment;

class CommentConverter implements CommentConverterInterface
{
    protected CommentRepositoryInterface $commentRepository;

    protected PostRepositoryInterface $postRepository;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function convert(WP_Comment $comment): Comment
    {
        return new Comment(
            $comment,
            $this->commentRepository,
            $this->postRepository,
            $this->userRepository
        );
    }

    public function revert(object $entity): WP_Comment
    {
        if ($entity instanceof CommentInterface) {
            return get_comment($entity->getId());
        }

        throw new InvalidArgumentException(
            '$entity must be an instance of ' . CommentInterface::class
        );
    }
}
