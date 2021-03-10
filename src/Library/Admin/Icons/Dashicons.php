<?php

namespace Leonidas\Library\Admin\Icons;

use Leonidas\Contracts\Admin\IconResolverInterface;

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
