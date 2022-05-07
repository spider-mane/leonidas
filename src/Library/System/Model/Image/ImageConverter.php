<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class ImageConverter implements PostConverterInterface
{
    protected AuthorRepositoryInterface $authorRepository;

    protected CommentRepositoryInterface $commentRepository;

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;
    }

    public function convert(WP_Post $post, ?string $size = null): Image
    {
        return new Image($post, $this->authorRepository, $this->commentRepository);
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof ImageInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            ImageInterface::class,
            $post,
            __METHOD__
        );
    }
}
