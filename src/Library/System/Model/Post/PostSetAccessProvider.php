<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\Post\Status\PostStatus;
use Leonidas\Library\System\Model\SetAccessProvider;

class PostSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    use DatableAccessProviderTrait;

    public function __construct(PostInterface $post)
    {
        parent::__construct($post, $this->resolvedSetters($post));
    }

    protected function resolvedSetters(PostInterface $post): array
    {
        $setGuid = fn ($guid) => $post->setGuid(new WebPage($guid));
        $setStatus = fn ($status) => $post->setStatus(new PostStatus($status));

        return [
            'status' => $setStatus,
            'guid' => $setGuid,
        ] + $this->resolvedDatableSetters($post);
    }
}
