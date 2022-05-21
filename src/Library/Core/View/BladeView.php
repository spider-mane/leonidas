<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;

class BladeView implements ViewInterface
{
    protected string $template;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function render(array $data = []): string
    {
        return '';
    }
}
