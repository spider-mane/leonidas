<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Twig\Environment;

class TwigView implements ViewInterface
{
    protected string $template;

    protected Environment $environment;

    public function __construct(Environment $environment, string $template)
    {
        $this->environment = $environment;
        $this->template = $template;
    }

    public function render(array $context = []): string
    {
        return $this->environment->render($this->template, $context);
    }
}
