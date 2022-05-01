<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class PageGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(PageInterface $page)
    {
        parent::__construct($page, $this->resolvedGetters($page));
    }

    protected function resolvedGetters(PageInterface $page): array
    {
        $dateFormat = PostEntityManagerInterface::DATE_FORMAT;

        $getDate = fn () => $page->getDate()->format($dateFormat);
        $getDateGmt = fn () => $page->getDateGmt()->format($dateFormat);
        $getDateModified = fn () => $page->getDateModified()->format($dateFormat);
        $getDateModifiedGmt = fn () => $page->getDateModifiedGmt()->format($dateFormat);
        $getGuid = fn () => $page->getGuid()->getHref();
        $getStatus = fn () => $page->getStatus()->getName();
        $getParent = fn () => $page->getParent()->getId();

        return [
            'date' => $getDate,
            'dateGmt' => $getDateGmt,
            'date_gmt' => $getDateGmt,
            'dateModified' => $getDateModified,
            'date_modified' => $getDateModified,
            'dateModifiedGmt' => $getDateModifiedGmt,
            'date_modified_gmt' => $getDateModifiedGmt,
            'status' => $getStatus,
            'guid' => $getGuid,
            'parent' => $getParent,
            'post_parent' => $getParent,
        ];
    }
}
