<?php

namespace Leonidas\Contracts\System\Model;

interface MimeInterface
{
    public function getMimeType(): string;

    public function setMimeType(string $mimeType): self;
}
