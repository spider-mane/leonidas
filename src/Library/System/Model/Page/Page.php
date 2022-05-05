<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
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
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Page\Status\PageStatus;
use WP_Post;

class Page implements PageInterface
{
    use AllAccessGrantedTrait;
    use FilterablePostModelTrait;
    use HierarchicalPostModelTrait;
    use LazyLoadableRelationshipsTrait;
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

    protected ?PageInterface $parent;

    protected PageCollectionInterface $children;

    protected PageRepositoryInterface $pageRepository;

    public function __construct(
        WP_Post $post,
        PageRepositoryInterface $pageRepository,
        AuthorRepositoryInterface $authorRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->validatePostType($post, 'page');

        $this->post = $post;
        $this->pageRepository = $pageRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;

        $this->getAccessProvider = new PageTemplateTags($this, $post);
        $this->setAccessProvider = new PageSetAccessProvider(
            $this,
            $this->pageRepository
        );
    }

    public function getParent(): ?PageInterface
    {
        return $this->lazyLoadableNullable('parent');
    }

    public function setParent(?PageInterface $parent): self
    {
        $this->parent = $parent;
        $this->post->post_parent = $parent ? $parent->getId() : 0;

        return $this;
    }

    public function getChildren(): PageCollectionInterface
    {
        return $this->lazyLoadable('$children');
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

    protected function getParentFromRepository(): ?PageInterface
    {
        return $this->pageRepository->select($this->getParentId());
    }

    protected function getChildrenFromRepository(): PageCollectionInterface
    {
        return $this->pageRepository->whereParent($this);
    }
}
