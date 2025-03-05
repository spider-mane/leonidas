<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\ActionInterface;

class Action implements ActionInterface
{
    public function __construct(
        protected string $text,
        protected string $link
    ) {
        //
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function jsonSerialize(): array
    {
        return [
            'text' => $this->getText(),
            'link' => $this->getLink()
        ];
    }
}
