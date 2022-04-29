<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait MutableContentPostModelTrait
{
    public function getContent(): string
    {
        return $this->post->post_content;
    }

    public function setContent(string $content): self
    {
        $this->post->post_content = $content;

        return $this;
    }
}
