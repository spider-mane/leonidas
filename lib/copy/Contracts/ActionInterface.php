<?php

namespace WebContent\Copy\Contracts;

interface ActionInterface extends ViewDataInterface
{
    public function getText(): string;

    public function getLink(): string;
}
