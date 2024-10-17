<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait TitledTrait
{
    use MappedToWpPostTrait;

    public function getTitle(): string
    {
        return $this->post->post_title;
    }
}
