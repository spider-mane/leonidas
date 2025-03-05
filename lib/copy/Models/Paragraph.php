<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\BodyInterface;

class Paragraph implements BodyInterface
{
    public function __construct(protected string $text)
    {
        //
    }

    public function getFormat(): string
    {
        return 'paragraph';
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function jsonSerialize(): string
    {
        return $this->getText();
    }
}
