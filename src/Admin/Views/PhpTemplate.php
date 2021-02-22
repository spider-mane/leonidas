<?php

namespace WebTheory\Leonidas\Admin\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;

class PhpTemplate implements ViewInterface
{
    /**
     * @var string;
     */
    protected $file;

    /**
     *
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     *
     */
    public function render(array $context = []): string
    {
        ob_start();

        include $this->file;

        return ob_get_clean();
    }
}
