<?php

namespace Leonidas\Contracts\System\Model;

interface RestrictableInterface
{
    public function getPassword(): ?string;

    public function setPassword(?string $password): self;
}
