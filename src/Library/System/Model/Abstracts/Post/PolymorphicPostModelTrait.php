<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait PolymorphicPostModelTrait
{
    use MappedToWpPostTrait;

    public function getPostFormat(): string
    {
        return get_post_format($this->post);
    }
}
