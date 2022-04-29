<?php

namespace Leonidas\Library\System\Model\Post;

use Closure;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;

class PostGetAccessProvider
{
    protected PostInterface $post;

    protected array $getters;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
        $this->getters = $this->gettablePropertyMap($post);
    }

    public function get(string $property)
    {
        if ($getter = $this->getters[$property] ?? null) {
            return $getter instanceof Closure
                ? $getter()
                : $this->post->$getter();
        }
    }

    protected function gettablePropertyMap(PostInterface $post): array
    {
        $dateFormat = PostEntityManagerInterface::DATE_FORMAT;

        $getDate = fn () => $post->getDate()->format($dateFormat);
        $getDateGmt = fn () => $post->getDateGmt()->format($dateFormat);
        $getDateModified = fn () => $post->getDateModified()->format($dateFormat);
        $getDateModifiedGmt = fn () => $post->getDateModifiedGmt()->format($dateFormat);
        $getGuid = fn () => $post->getGuid()->getHref();
        $getStatus = fn () => $post->getStatus()->getName();

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
            'guid' => $getGuid,
            'menuOrder' => 'getMenuOrder',
            'menu_order' => 'getMenuOrder',
            'postType' => 'getPostType',
            'post_type' => 'getPostType',
            'mimeType' => 'getMimeType',
            'mime_type' => 'getMimeType',
            'commentCount' => 'getCommentCount',
            'comment_count' => 'getCommentCount',
            'filter' => 'getFilter',
        ];
    }
}
