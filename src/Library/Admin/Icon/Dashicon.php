<?php

namespace Leonidas\Library\Admin\Icon;

use Leonidas\Contracts\Admin\IconResolverInterface;

class Dashicon implements IconResolverInterface
{
    protected $icon;

    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    public function get(): string
    {
        return 'dashicons-' . $this->icon;
    }
}
