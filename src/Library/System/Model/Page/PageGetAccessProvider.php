<?php

namespace Leonidas\Library\System\Model\Page;

use Closure;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;

class PageGetAccessProvider
{
    protected PageInterface $page;

    protected array $getters;

    public function __construct(PageInterface $page)
    {
        $this->page = $page;
        $this->getters = $this->gettablePropertyMap($page);
    }

    public function get(string $property)
    {
        if ($getter = $this->getters[$property] ?? null) {
            return $getter instanceof Closure
                ? $getter()
                : $this->page->$getter();
        }
    }

    protected function gettablePropertyMap(PageInterface $page): array
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
            'id' => 'getId',
            'author' => 'getAuthor',
            'date' => $getDate,
            'dateGmt' => $getDateGmt,
            'date_gmt' => $getDateGmt,
            'dateModified' => $getDateModified,
            'date_modified' => $getDateModified,
            'dateModifiedGmt' => $getDateModifiedGmt,
            'date_modified_gmt' => $getDateModifiedGmt,
            'content' => 'getContent',
            'title' => 'getTitle',
            'excerpt' => 'getExcerpt',
            'status' => $getStatus,
            'commentStatus' => 'getCommentStatus',
            'comment_status' => 'getCommentStatus',
            'pingStatus' => 'getPingStatus',
            'ping_status' => 'getPingStatus',
            'password' => 'getPassword',
            'name' => 'getName',
            'pingQueue' => 'getPingQueue',
            'to_ping' => 'getPingQueue',
            'isPinged' => 'hasBeenPinged',
            'pinged' => 'hasBeenPinged',
            'contentFiltered' => 'getContentFiltered',
            'content_filtered' => 'getContentFiltered',
            'guid' => $getGuid,
            'menuOrder' => 'getMenuOrder',
            'menu_order' => 'getMenuOrder',
            'pageType' => 'getPostType',
            'page_type' => 'getPostType',
            'mimeType' => 'getMimeType',
            'mime_type' => 'getMimeType',
            'commentCount' => 'getCommentCount',
            'comment_count' => 'getCommentCount',
            'filter' => 'getFilter',
            'parent' => $getParent,
            'post_parent' => $getParent,
        ];
    }
}
