<?php

namespace Leonidas\Contracts\Admin\Icon;

interface IconResolverInterface
{
    /**
     * @return string The icon uri
     */
    public function get(): string;
}
