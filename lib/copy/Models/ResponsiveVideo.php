<?php

namespace WebContent\Copy\Models;

use WebContent\Copy\Contracts\VisualMediaInterface;

class ResponsiveVideo implements VisualMediaInterface
{
    public function __construct(protected array $ref)
    {
        //
    }

    public function getType(): string
    {
        return 'responsive-video';
    }

    public function getData(): array
    {
        return $this->ref;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => $this->getType(),
            'ref' => $this->getData(),
        ];
    }
}
