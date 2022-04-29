<?php

namespace Leonidas\Library\System\Model\Post;

use Closure;
use DateTime;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Post\Status\PostStatus;

class PostSetAccessProvider implements SetAccessProviderInterface
{
    protected PostInterface $post;

    protected array $setters;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
        $this->setters = $this->settablePropertyMap($post);
    }

    public function set($property, $value)
    {
        if ($setter = $this->setters[$property] ?? null) {
            $setter instanceof Closure
                ? $setter($value)
                : $this->post->$setter($value);
        }
    }

    protected function settablePropertyMap(PostInterface $post): array
    {
        $setDate = fn ($date) => $post->setDate(new DateTime($date));
        $setDateGmt = fn ($date) => $post->setDateGmt(new DateTime($date));
        $setDateModified = fn ($date) => $post->setDateModified(new DateTime($date));
        $setDateModifiedGmt = fn ($date) => $post->setDateModifiedGmt(new DateTime($date));
        $setGuid = fn ($guid) => $post->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $post->setStatus(new PostStatus($status));

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
            'guid' => $setGuid,
            'menuOrder' => 'setMenuOrder',
            'menu_order' => 'setMenuOrder',
            'mimeType' => 'setMimeType',
            'mime_type' => 'setMimeType',
            'commentCount' => 'setCommentCount',
            'comment_count' => 'setCommentCount',
            'filter' => 'setFilter',
        ];
    }
}
