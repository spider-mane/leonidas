<?php

namespace WebTheory\Leonidas\Contracts\Admin;

interface IconResolverInterface
{
    /**
     * @return string The icon uri
     */
    public function get(): string;
}
