<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Library\System\Model\GetAccessProvider;

class PostGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    public function __construct(PostInterface $post)
    {
        parent::__construct($post, $this->resolvedGetters($post));
    }

    protected function resolvedGetters(PostInterface $post): array
    {
        $dateFormat = PostEntityManagerInterface::DATE_FORMAT;

        $getDate = fn () => $post->getDate()->format($dateFormat);
        $getDateGmt = fn () => $post->getDateGmt()->format($dateFormat);
        $getDateModified = fn () => $post->getDateModified()->format($dateFormat);
        $getDateModifiedGmt = fn () => $post->getDateModifiedGmt()->format($dateFormat);
        $getGuid = fn () => $post->getGuid()->getHref();
        $getStatus = fn () => $post->getStatus()->getName();

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
        ];
    }
}
