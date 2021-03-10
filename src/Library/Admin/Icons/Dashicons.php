<?php

namespace WebTheory\Leonidas\Library\Admin\Icons;

use WebTheory\Leonidas\Contracts\Admin\IconResolverInterface;

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
