<?php

namespace WebContent\Copy\Contracts;

interface BodyInterface extends ViewDataInterface
{
    public function getFormat(): string;

    public function getText(): string;
}
