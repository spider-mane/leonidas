<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class PageConverter extends AbstractModelConverter implements PostConverterInterface
{
    public function convert(WP_Post $post): Page
    {
        return new Page($post, $this->autoInvoker);
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof PageInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            PageInterface::class,
            $post,
            __METHOD__
        );
    }
}
