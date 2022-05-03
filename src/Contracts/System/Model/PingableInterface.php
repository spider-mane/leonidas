<?php

namespace Leonidas\Contracts\System\Model;

interface PingableInterface
{
    public function getPingStatus(): string;

    public function getPinged(): string;

    public function getToBePinged(): string;

    public function setPingStatus(string $pingStatus): self;

    public function setPinged(string $pinged): self;

    public function setToBePinged(string $toBePinged): self;
}
