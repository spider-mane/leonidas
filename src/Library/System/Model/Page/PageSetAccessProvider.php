<?php

namespace Leonidas\Library\System\Model\Page;

use DateTime;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Page\Status\PageStatus;
use Leonidas\Library\System\Model\SetAccessProvider;

class PageSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(PageInterface $page, PageRepositoryInterface $pageRepository)
    {
        parent::__construct($page, $this->resolvedSetters($page, $pageRepository));
    }

    protected function resolvedSetters(PageInterface $page, PageRepositoryInterface $pageRepository): array
    {
        $setDate = fn ($date) => $page->setDate(new DateTime($date));
        $setDateGmt = fn ($date) => $page->setDateGmt(new DateTime($date));
        $setDateModified = fn ($date) => $page->setDateModified(new DateTime($date));
        $setDateModifiedGmt = fn ($date) => $page->setDateModifiedGmt(new DateTime($date));
        $setGuid = fn ($guid) => $page->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $page->setStatus(new PageStatus($status));
        $setParent = fn ($parent) => $page->setParent($pageRepository->select((int)$parent));

        return [
            'date' => $setDate,
            'dateGmt' => $setDateGmt,
            'date_gmt' => $setDateGmt,
            'dateModified' => $setDateModified,
            'date_modified' => $setDateModified,
            'dateModifiedGmt' => $setDateModifiedGmt,
            'date_modified_gmt' => $setDateModifiedGmt,
            'status' => $setStatus,
            'guid' => $setGuid,
            'parent' => $setParent,
            'post_parent' => $setParent,
        ];
    }
}
