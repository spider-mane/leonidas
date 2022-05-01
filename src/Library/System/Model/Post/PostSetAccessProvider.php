<?php

namespace Leonidas\Library\System\Model\Post;

use DateTime;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Post\Status\PostStatus;
use Leonidas\Library\System\Model\SetAccessProvider;

class PostSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(PostInterface $post)
    {
        parent::__construct($post, $this->resolvedSetters($post));
    }

    protected function resolvedSetters(PostInterface $post): array
    {
        $setDate = fn ($date) => $post->setDate(new DateTime($date));
        $setDateGmt = fn ($date) => $post->setDateGmt(new DateTime($date));
        $setDateModified = fn ($date) => $post->setDateModified(new DateTime($date));
        $setDateModifiedGmt = fn ($date) => $post->setDateModifiedGmt(new DateTime($date));
        $setGuid = fn ($guid) => $post->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $post->setStatus(new PostStatus($status));

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
        ];
    }
}
