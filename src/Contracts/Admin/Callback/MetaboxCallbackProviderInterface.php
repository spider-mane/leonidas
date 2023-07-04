<?php

namespace Leonidas\Contracts\Admin\Callback;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

interface MetaboxCallbackProviderInterface
{
    /**
     * @return callable(WP_Post $post, array $data): void
     */
    public function getRenderingCallback(MetaboxInterface $metabox, ServerRequestInterface $request): callable;
}
