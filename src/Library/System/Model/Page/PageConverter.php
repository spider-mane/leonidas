<?php

namespace Leonidas\Library\System\Model\Page;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class PageConverter implements PostConverterInterface
{
    protected PageRepositoryInterface $pageRepository;

    protected AuthorRepositoryInterface $authorRepository;

    protected CommentRepositoryInterface $commentRepository;

    protected string $postTypePrefix = '';

    public function __construct(
        PageRepositoryInterface $pageRepository,
        AuthorRepositoryInterface $authorRepository,
        CommentRepositoryInterface $commentRepository,
        string $postTypePrefix = ''
    ) {
        $this->pageRepository = $pageRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;
        $this->postTypePrefix = $postTypePrefix;
    }

    public function convert(WP_Post $post): Page
    {
        return new Page(
            $post,
            $this->pageRepository,
            $this->authorRepository,
            $this->commentRepository,
            $this->getAccessProvider,
            $this->setAccessProvider,
            $this->postTypePrefix
        );
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PageInterface) {
            return get_post($post->getId());
        }

        throw new InvalidArgumentException(
            '$post must be an instance of ' . PageInterface::class
        );
    }
}
