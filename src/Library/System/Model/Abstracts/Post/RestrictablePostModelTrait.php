<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait RestrictablePostModelTrait
{
    use MappedToWpPostTrait;

    public function getPassword(): ?string
    {
        return $this->post->post_password;
    }

    public function setPassword(?string $password): self
    {
        $this->post->post_password = $password;

        return $this;
    }
}
