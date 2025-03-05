<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\VisualMediaInterface;

class VisualMedia implements VisualMediaInterface
{
    public function __construct(
        protected string $type,
        protected mixed $data,
    ) {
        //
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'data' => $this->getData(),
        ];
    }
}
