<?php

namespace Leonidas\Library\Admin\Views;

use Leonidas\Library\Admin\Access\Twig;

abstract class AbstractLeonidasTwigView
{
    protected string $template;

    public function render(array $context = []): string
    {
        return Twig::render($this->getTemplate(), $context);
    }

    protected function getTemplate(): string
    {
        return $this->template;
    }
}
