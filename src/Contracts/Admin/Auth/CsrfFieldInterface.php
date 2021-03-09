<?php

namespace WebTheory\Leonidas\Contracts\Admin\Auth;

interface CsrfFieldInterface
{
    public function render(): string;

    public function getTag(): string;

    /**
     * Get the base name of the screen the field is intended for
     */
    public function getScreen(): string;
}
