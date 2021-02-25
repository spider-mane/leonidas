<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface IconResolverInterface
{
    /**
     * @return string The icon uri
     */
    public function get(): string;
}
