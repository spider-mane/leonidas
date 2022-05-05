<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class PageConverter implements PostConverterInterface
{
    protected PageRepositoryInterface $pageRepository;

    protected AuthorRepositoryInterface $authorRepository;

    protected CommentRepositoryInterface $commentRepository;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        AuthorRepositoryInterface $authorRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->pageRepository = $pageRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;
    }

    public function convert(WP_Post $post): Page
    {
        return new Page(
            $post,
            $this->pageRepository,
            $this->authorRepository,
            $this->commentRepository
        );
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PageInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            PageInterface::class,
            $post,
            __METHOD__
        );
    }
}
