<?php

namespace WebTheory\Leonidas\Admin\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;

class BladeView implements ViewInterface
{
    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     *
     */
    public function render(array $context = []): string
    {
        //
    }
}
