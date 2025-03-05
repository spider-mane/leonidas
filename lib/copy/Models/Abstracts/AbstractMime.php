<?php

namespace WebContent\Copy\Models\Abstracts;

use WebContent\Copy\Contracts\MimeInterface;
use WebContent\Copy\Contracts\VisualMediaInterface;

abstract class AbstractMime implements MimeInterface
{
    public function __construct(
        protected string $type,
        protected int|string $id,
        protected string $src,
        protected string $srcset,
    ) {
        //
    }

    public function getMimeType(): string
    {
        return $this->type;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function getSrcset(): string
    {
        return $this->srcset;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getMimeType(),
            'id' => $this->getId(),
            'src' => $this->getSrc(),
            'srcset' => $this->getSrcset(),
        ];
    }
}
