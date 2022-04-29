<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait RestrictablePostModelTrait
{
    protected WP_Post $post;

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
