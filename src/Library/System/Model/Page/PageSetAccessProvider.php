<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Page\Status\PageStatus;
use Leonidas\Library\System\Model\SetAccessProvider;

class PageSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(PageInterface $page, AutoInvokerInterface $invoker)
    {
        parent::__construct($page, $this->resolvedSetters($page, $invoker));
    }

    protected function resolvedSetters(PageInterface $page, AutoInvokerInterface $invoker): array
    {
        $setGuid = fn ($guid) => $page->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $page->setStatus(new PageStatus($status));
        $setParent = fn ($parent) => $this->setParent($page, (int) $parent, $invoker);

        return [
                'status' => $setStatus,
                'guid' => $setGuid,
                'parent' => $setParent,
                'post_parent' => $setParent,
            ] + $this->resolvedDatableSetters($page);
    }

    protected function setParent(PageInterface $page, int $parent, AutoInvokerInterface $invoker): PageInterface
    {
        return $page->setParent($this->getPageRepository($invoker)->select($parent));
    }

    protected function getPageRepository(AutoInvokerInterface $invoker): PageRepositoryInterface
    {
        return $invoker->invoke(
            fn (PageRepositoryInterface $repository) => $repository
        );
    }
}
