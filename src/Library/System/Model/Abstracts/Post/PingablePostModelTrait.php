<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait PingablePostModelTrait
{
    use MappedToWpPostTrait;

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
