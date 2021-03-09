<?php

namespace WebTheory\Leonidas\Admin;

use Twig\Environment;
use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractTwigView;

class TwigView extends AbstractTwigView implements ViewInterface
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var Environment
     */
    protected $twigEnvironment;

    /**
     *
     */
    public function __construct(string $template, Environment $environment)
    {
        $this->template = $template;
        $this->twigEnvironment = $environment;
    }

    /**
     *
     */
    protected function getTwigEnvironment(): Environment
    {
        return $this->twigEnvironment;
    }

    /**
     *
     */
    protected function getTemplate(): string
    {
        return $this->template;
    }
}
