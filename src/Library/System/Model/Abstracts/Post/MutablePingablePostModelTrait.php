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

    public function setPinged(string $pinged): self
    {
        $this->post->pinged = $pinged;

        return $this;
    }

    public function setToBePinged(string $toBePinged): self
    {
        $this->post->to_ping = $toBePinged;

        return $this;
    }
}
