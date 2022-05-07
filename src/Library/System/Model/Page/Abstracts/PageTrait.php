<?php

namespace Leonidas\Library\System\Model\Page\Abstracts;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\Status\PageStatusInterface;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MappedToWpPostTrait;
use Leonidas\Library\System\Model\Page\Status\PageStatus;

trait PageTrait
{
    use LazyLoadableRelationshipsTrait;
    use MappedToWpPostTrait;

    protected ?PageInterface $parent;

    protected PageCollectionInterface $children;

    protected PageRepositoryInterface $pageRepository;

    public function getParent(): ?PageInterface
    {
        return $this->lazyLoadableNullable('parent');
    }

    public function getChildren(): PageCollectionInterface
    {
        return $this->lazyLoadable('children');
    }

    public function getStatus(): PageStatusInterface
    {
        return new PageStatus($this->post->post_status);
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
