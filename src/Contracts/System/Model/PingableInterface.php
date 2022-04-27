<?php

namespace Leonidas\Contracts\System\Model;

interface PingableInterface
{
    public function getPingStatus(): string;

    public function getPingQueue(): string;

    public function hasBeenPinged(): bool;

    public function setPingStatus(string $pingStatus): self;

    public function setPingQueue(string $pingQueue): self;

    public function setHasBeenPinged(bool $hasBeenPinged): self;
}
