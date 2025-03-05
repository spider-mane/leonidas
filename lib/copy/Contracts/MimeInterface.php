<?php

namespace WebContent\Copy\Contracts;

interface MimeInterface extends ViewDataInterface
{
    public function getMimeType(): string;

    public function getId(): int|string;

    public function getSrc(): string;

    public function getSrcset(): string;
}
