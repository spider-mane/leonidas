<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class PostConverter implements PostConverterInterface
{
    protected AuthorRepositoryInterface $authorRepository;

    protected TagRepositoryInterface $tagRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    protected CommentRepositoryInterface $commentRepository;

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
    }

    public function convert(WP_Post $post): PostInterface
    {
        return new Post(
            $post,
            $this->authorRepository,
            $this->tagRepository,
            $this->categoryRepository,
            $this->commentRepository
        );
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PostInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            PostInterface::class,
            $post,
            __METHOD__
        );
    }
}
