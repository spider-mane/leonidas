<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\HierarchicalPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableContentPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use Leonidas\Library\System\Model\Page\Status\PageStatus;
use Leonidas\Library\System\Schema\Post\Traits\ValidatesPostTypeTrait;
use ReturnTypeWillChange;
use WP_Post;

class Page implements PageInterface
{
    use FilterablePostModelTrait;
    use HierarchicalPostModelTrait;
    use MimePostModelTrait;
    use MutableAuthoredPostModelTrait;
    use MutableCommentablePostModelTrait;
    use MutableContentPostModelTrait;
    use MutableDatablePostModelTrait;
    use MutablePingablePostModelTrait;
    use MutablePostModelTrait;
    use RestrictablePostModelTrait;
    use ValidatesPostTypeTrait;

    protected WP_Post $post;

    protected PageRepositoryInterface $pageRepository;

    protected GetAccessProviderInterface $getAccessProvider;

    protected SetAccessProviderInterface $setAccessProvider;

    public function __construct(
        WP_Post $post,
        PageRepositoryInterface $pageRepository,
        AuthorRepositoryInterface $authorRepository,
        CommentRepositoryInterface $commentRepository,
        ?GetAccessProviderInterface $getAccessProvider = null,
        ?SetAccessProviderInterface $setAccessProvider = null,
        string $postTypePrefix = ''
    ) {
        $this->validatePostType($post, $postTypePrefix . 'post');

        $this->post = $post;
        $this->pageRepository = $pageRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;

        $this->getAccessProvider = $getAccessProvider
            ?? new PageGetAccessProvider($this);

        $this->setAccessProvider = $setAccessProvider
            ?? new PageSetAccessProvider($this, $this->pageRepository);
    }

    #[ReturnTypeWillChange]
    public function __get($name)
    {
        $this->getAccessProvider->get($name);
    }

    public function __set($name, $value): void
    {
        $this->setAccessProvider->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->post->__isset($name);
    }

    public function __toString(): string
    {
        return $this->getContent();
    }

    public function getParent(): ?PageInterface
    {
        return $this->pageRepository->select((int) $this->post->post_parent);
    }

    public function setParent(?PageInterface $parent): self
    {
        $this->post->post_parent = $parent ? $parent->getId() : 0;

        return $this;
    }

    public function getChildren(): PageCollectionInterface
    {
        return $this->pageRepository->whereParent($this);
    }

    public function getStatus(): PageStatusInterface
    {
        return new PageStatus($this->post->post_status);
    }

    public function setStatus(PageStatusInterface $status): self
    {
        $this->post->post_status = $status->getName();

        return $this;
    }
}
