<?php

namespace WebContent\Copy\Contracts;

interface VisualMediaInterface extends ViewDataInterface
{
    public function getType(): string;

    public function getData(): mixed;
}
