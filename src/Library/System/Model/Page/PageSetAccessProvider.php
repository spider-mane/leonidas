<?php

namespace Leonidas\Library\System\Model\Page;

use Closure;
use DateTime;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Page\Status\PageStatus;

class PageSetAccessProvider implements SetAccessProviderInterface
{
    protected PageInterface $page;

    protected PageRepositoryInterface $pageRepository;

    protected array $setters;

    public function __construct(PageInterface $page, PageRepositoryInterface $pageRepository)
    {
        $this->page = $page;
        $this->pageRepository = $pageRepository;
        $this->setters = $this->settablePropertyMap($page);
    }

    public function set($property, $value)
    {
        if ($setter = $this->setters[$property] ?? null) {
            $setter instanceof Closure
                ? $setter($value)
                : $this->page->$setter($value);
        }
    }

    protected function settablePropertyMap(PageInterface $page): array
    {
        $setDate = fn ($date) => $page->setDate(new DateTime($date));
        $setDateGmt = fn ($date) => $page->setDateGmt(new DateTime($date));
        $setDateModified = fn ($date) => $page->setDateModified(new DateTime($date));
        $setDateModifiedGmt = fn ($date) => $page->setDateModifiedGmt(new DateTime($date));
        $setGuid = fn ($guid) => $page->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $page->setStatus(new PageStatus($status));
        $setParent = fn ($parent) => $page->setParent($this->pageRepository->select((int) $parent));

        return [
            'author' => 'setAuthor',
            'date' => $setDate,
            'dateGmt' => $setDateGmt,
            'date_gmt' => $setDateGmt,
            'dateModified' => $setDateModified,
            'date_modified' => $setDateModified,
            'dateModifiedGmt' => $setDateModifiedGmt,
            'date_modified_gmt' => $setDateModifiedGmt,
            'content' => 'setContent',
            'title' => 'setTitle',
            'excerpt' => 'setExcerpt',
            'status' => $setStatus,
            'commentStatus' => 'setCommentStatus',
            'comment_status' => 'setCommentStatus',
            'pingStatus' => 'setPingStatus',
            'ping_status' => 'setPingStatus',
            'password' => 'setPassword',
            'name' => 'setName',
            'pingQueue' => 'setPingQueue',
            'pinged' => 'hasBeenPinged',
            'contentFiltered' => 'setContentFiltered',
            'content_filtered' => 'setContentFiltered',
            'guid' => $setGuid,
            'menuOrder' => 'setMenuOrder',
            'menu_order' => 'setMenuOrder',
            'mimeType' => 'setMimeType',
            'mime_type' => 'setMimeType',
            'commentCount' => 'setCommentCount',
            'comment_count' => 'setCommentCount',
            'filter' => 'setFilter',
            'parent' => $setParent,
            'post_parent' => $setParent,
        ];
    }
}
