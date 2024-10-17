<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait MutableTitledTrait
{
    use TitledTrait;

    public function setTitle(string $title): static
    {
        $this->post->post_title = $title;

        return $this;
    }
}
