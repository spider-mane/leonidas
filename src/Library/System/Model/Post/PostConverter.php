<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class PostConverter extends AbstractModelConverter implements PostConverterInterface
{
    public function convert(WP_Post $post): PostInterface
    {
        return new Post($post, $this->autoInvoker);
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PostInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            PostInterface::class,
            $post,
            __METHOD__
        );
    }
}
