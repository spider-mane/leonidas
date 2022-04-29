<?php

namespace Leonidas\Library\System\Model\Post;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class PostConverter implements PostConverterInterface
{
    protected AuthorRepositoryInterface $userRepository;

    protected TagRepositoryInterface $tagRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    protected CommentRepositoryInterface $commentRepository;

    protected ?GetAccessProviderInterface $getAccessProvider;

    protected ?SetAccessProviderInterface $setAccessProvider;

    protected string $postTypePrefix = '';

    public function __construct(
        AuthorRepositoryInterface $userRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository,
        ?GetAccessProviderInterface $getAccessProvider = null,
        ?SetAccessProviderInterface $setAccessProvider = null,
        string $postTypePrefix = ''
    ) {
        $this->userRepository = $userRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
        $this->getAccessProvider = $getAccessProvider;
        $this->setAccessProvider = $setAccessProvider;
        $this->postTypePrefix = $postTypePrefix;
    }

    public function convert(WP_Post $post): Post
    {
        return new Post(
            $post,
            $this->userRepository,
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
        if ($post instanceof Post) {
            return get_post($post->getId());
        }

        throw new InvalidArgumentException(
            '$post must be an instance of ' . Post::class
        );
    }
}
