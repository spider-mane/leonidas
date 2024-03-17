<?php

namespace Leonidas\Library\Core\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Twig\Environment;

class TwigView implements ViewInterface
{
    protected Environment $environment;

    protected string $view;

    public function __construct(Environment $environment, string $view)
    {
        $this->environment = $environment;
        $this->view = $view;
    }

    public function render(array $context = []): string
    {
        return $this->environment->render($this->view, $context);
    }
}
