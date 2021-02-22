<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface ViewInterface
{
    /**
     *
     */
    public function render(array $context = []): string;
}
