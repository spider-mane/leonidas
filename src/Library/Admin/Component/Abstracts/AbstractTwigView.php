<?php

namespace Leonidas\Library\Admin\Component\Abstracts;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Access\Twig;

abstract class AbstractTwigView implements ViewInterface
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
