<?php

namespace WebTheory\Leonidas\Admin\Icons;

use WebTheory\Leonidas\Admin\Contracts\IconResolverInterface;

class Dashicons implements IconResolverInterface
{
    /**
     *
     */
    protected $icon;

    /**
     *
     */
    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    /**
     *
     */
    public function get(): string
    {
        return 'dashicons-' . $this->icon;
    }
}
