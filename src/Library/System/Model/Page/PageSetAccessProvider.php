<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Page\Status\PageStatus;
use Leonidas\Library\System\Model\SetAccessProvider;

class PageSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(PageInterface $page, PageRepositoryInterface $pageRepository)
    {
        parent::__construct($page, $this->resolvedSetters($page, $pageRepository));
    }

    protected function resolvedSetters(PageInterface $page, PageRepositoryInterface $pageRepository): array
    {
        $setGuid = fn ($guid) => $page->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $page->setStatus(new PageStatus($status));
        $setParent = fn ($parent) => $page->setParent($pageRepository->select((int) $parent));

        return [
            'status' => $setStatus,
            'guid' => $setGuid,
            'parent' => $setParent,
            'post_parent' => $setParent,
        ] + $this->resolvedDatableSetters($page);
    }
}
