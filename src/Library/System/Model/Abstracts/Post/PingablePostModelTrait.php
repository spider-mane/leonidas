<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait PingablePostModelTrait
{
    protected WP_Post $post;

    public function getPingStatus(): string
    {
        return $this->post->ping_status;
    }

    public function getPinged(): string
    {
        return $this->post->pinged;
    }

    public function getToBePinged(): string
    {
        return $this->post->to_ping;
    }
}
