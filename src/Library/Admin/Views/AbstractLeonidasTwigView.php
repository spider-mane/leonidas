<?php

namespace Leonidas\Library\Admin\Views;

use Leonidas\Library\Admin\Proxies\TwigLoader;

abstract class AbstractLeonidasTwigView
{
    /**
     * @var string
     */
    protected $template;

    public function render(array $context = []): string
    {
        return TwigLoader::render($this->getTemplate(), $context);
    }

    /**
     *
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }
}
