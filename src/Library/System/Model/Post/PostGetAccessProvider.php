<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\GetAccessProvider;

class PostGetAccessProvider extends GetAccessProvider implements GetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(PostInterface $post)
    {
        parent::__construct($post, $this->resolvedGetters($post));
    }

    protected function resolvedGetters(PostInterface $post): array
    {
        $getGuid = fn () => $post->getGuid()->getHref();
        $getStatus = fn () => $post->getStatus()->getName();

        return [
            'status' => $getStatus,
            'guid' => $getGuid,
        ] + $this->resolvedDatableGetters($post);
    }
}
