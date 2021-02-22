<?php

namespace WebTheory\Leonidas\Admin;

use WebTheory\Leonidas\Admin\Contracts\IconResolverInterface;

class DashiconsIconResolver implements IconResolverInterface
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
    public function getIcon(): string
    {
        return 'dasicons-' . $this->icon;
    }
}
