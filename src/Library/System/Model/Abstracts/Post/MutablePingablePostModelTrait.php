<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait MutablePingablePostModelTrait
{
    use PingablePostModelTrait;

    public function setPingStatus(string $pingStatus): self
    {
        $this->post->ping_status = $pingStatus;

        return $this;
    }

    public function setPingQueue(string $pingQueue): self
    {
        $this->post->to_ping = $pingQueue;

        return $this;
    }

    public function setHasBeenPinged(bool $hasBeenPinged): self
    {
        $this->post->pinged = $hasBeenPinged;

        return $this;
    }
}
