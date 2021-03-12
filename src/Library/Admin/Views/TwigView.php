<?php

namespace Leonidas\Library\Admin;

use Twig\Environment;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractTwigView;

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
