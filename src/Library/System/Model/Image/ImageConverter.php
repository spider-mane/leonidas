<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class ImageConverter extends AbstractModelConverter implements PostConverterInterface
{
    public function convert(WP_Post $post, ?string $size = null): Image
    {
        return new Image($post, $this->autoInvoker);
    }

    public function revert(object $post): WP_Post
    {
        if ($post instanceof ImageInterface) {
            return get_post($post->getId());
        }

        throw new UnexpectedEntityException(
            ImageInterface::class,
            $post,
            __METHOD__
        );
    }
}
