<?php

namespace WebTheory\Leonidas\Admin\Views;

use Twig\Environment;
use WebTheory\Leonidas\Leonidas;

abstract class AbstractLeonidasTwigView extends AbstractTwigView
{
    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    protected function getTwigEnvironment(): Environment
    {
        return Leonidas::get('container')->get('twig');
    }

    /**
     *
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }
}
