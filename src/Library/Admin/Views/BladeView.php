<?php

namespace WebTheory\Leonidas\Library\Admin\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;

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
