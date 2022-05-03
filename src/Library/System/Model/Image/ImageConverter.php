<?php

namespace Leonidas\Library\System\Model\Image;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class ImageConverter implements PostConverterInterface
{
    protected UserRepositoryInterface $userRepository;

    protected CommentRepositoryInterface $commentRepository;

    protected string $postTypePrefix = '';

    public function __construct(
        UserRepositoryInterface $userRepository,
        CommentRepositoryInterface $commentRepository,
        string $postTypePrefix = ''
    ) {
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->postTypePrefix = $postTypePrefix;
    }

    public function convert(WP_Post $post, ?string $size = null): Image
    {
        return new Image(
            $post,
            $this->userRepository,
            $this->commentRepository,
            $this->postTypePrefix
        );
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof ImageInterface) {
            return get_post($post->getId());
        }

        throw new InvalidArgumentException(
            '$post must be an instance of ' . ImageInterface::class
        );
    }
}
