<?php

namespace Leonidas\Library\System\Model\Post;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class PostConverter implements PostConverterInterface
{
    protected AuthorRepositoryInterface $authorRepository;

    protected TagRepositoryInterface $tagRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    protected CommentRepositoryInterface $commentRepository;

    protected string $postTypePrefix = '';

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository,
        string $postTypePrefix = ''
    ) {
        $this->authorRepository = $authorRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
        $this->postTypePrefix = $postTypePrefix;
    }

    public function convert(WP_Post $post): Post
    {
        return new Post(
            $post,
            $this->authorRepository,
            $this->tagRepository,
            $this->categoryRepository,
            $this->commentRepository,
            $this->getAccessProvider,
            $this->setAccessProvider,
            $this->postTypePrefix
        );
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PostInterface) {
            return get_post($post->getId());
        }

        throw new InvalidArgumentException(
            '$post must be an instance of ' . PostInterface::class
        );
    }
}
