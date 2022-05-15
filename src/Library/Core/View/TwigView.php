<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Twig\Environment;

class TwigView extends AbstractTwigView implements ViewInterface
{
    protected string $template;

    protected Environment $twigEnvironment;

    public function __construct(string $template, Environment $environment)
    {
        $this->template = $template;
        $this->twigEnvironment = $environment;
    }

    protected function getTwigEnvironment(): Environment
    {
        return $this->twigEnvironment;
    }

    protected function getTemplate(): string
    {
        return $this->template;
    }
}
