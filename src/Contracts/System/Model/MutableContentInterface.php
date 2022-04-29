<?php

namespace Leonidas\Contracts\System\Model;

interface MutableContentInterface
{
    public function getContent(): string;

    public function setContent(string $content): self;
}
