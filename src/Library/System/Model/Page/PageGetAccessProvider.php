<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\GetAccessProvider;

class PageGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(PageInterface $page)
    {
        parent::__construct($page, $this->resolvedGetters($page));
    }

    protected function resolvedGetters(PageInterface $page): array
    {
        $getGuid = fn () => $page->getGuid()->getHref();
        $getStatus = fn () => $page->getStatus()->getName();
        $getParent = fn () => $page->getParent()->getId();

        return [
            'status' => $getStatus,
            'guid' => $getGuid,
            'parent' => $getParent,
            'post_parent' => $getParent,
        ] + $this->resolvedDatableGetters($page);
    }
}
