<?php

namespace Leonidas\Library\Admin\Views;

use Leonidas\Library\Admin\Proxies\Twig;

abstract class AbstractLeonidasTwigView
{
    /**
     * @var string
     */
    protected $template;

    public function render(array $context = []): string
    {
        return Twig::render($this->getTemplate(), $context);
    }

    /**
     *
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }
}
