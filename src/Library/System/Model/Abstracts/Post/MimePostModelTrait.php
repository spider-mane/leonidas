<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait MimePostModelTrait
{
    protected WP_Post $post;

    public function getMimeType(): string
    {
        return $this->post->post_mime_type;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->post->post_mime_type = $mimeType;

        return $this;
    }
}
