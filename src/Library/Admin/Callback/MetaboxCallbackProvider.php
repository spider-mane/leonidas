<?php

namespace Leonidas\Library\Admin\Callback;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

class MetaboxCallbackProvider implements MetaboxCallbackProviderInterface
{
    public function getRenderingCallback(MetaboxInterface $metabox, ServerRequestInterface $request): callable
    {
        return function (WP_Post $post, array $data) use ($metabox, $request): void {
            $request = $request
                ->withAttribute('post', $post)
                ->withAttribute('metabox', $data);

            echo $metabox->renderComponent($request);
        };
    }
}
