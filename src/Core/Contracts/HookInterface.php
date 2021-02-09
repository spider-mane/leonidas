<?php

namespace WebTheory\Leonidas\Core\Contracts;

interface HookInterface
{
    /**
     *
     */
    public function getTag(): string;

    /**
     *
     */
    public function getArgs(): array;
}
