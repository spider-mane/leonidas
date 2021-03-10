<?php

namespace Leonidas\Library\Admin\Views;

use Twig\Environment;

abstract class AbstractTwigView
{
    /**
     *
     */
    public function render(array $context = []): string
    {
        return $this->getTwigEnvironment()->render($this->getTemplate(), $context);
    }

    /**
     *
     */
    abstract protected function getTwigEnvironment(): Environment;

    /**
     *
     */
    abstract protected function getTemplate(): string;
}
