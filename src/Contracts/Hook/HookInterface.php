<?php

namespace Leonidas\Contracts\Hook;

interface HookInterface
{
    public function getTag(): string;

    public function getArgs(): array;
}
