<?php

namespace Leonidas\Library\System\Request\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

trait ExpectsPostEntityTrait
{
    protected function getPost(ServerRequestInterface $request): ?WP_Post
    {
        return $request->getAttribute('post');
    }

    protected function getPostId(ServerRequestInterface $request): ?int
    {
        $post = $this->getPost($request);

        return $post ? $post->ID : null;
    }
}
