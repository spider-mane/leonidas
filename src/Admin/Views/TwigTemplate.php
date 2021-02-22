<?php

namespace WebTheory\Leonidas\Admin;

use Twig\Environment;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;

class TwigTemplate implements ViewInterface
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var Environment
     */
    protected $environment;

    /**
     *
     */
    public function __construct(string $template, Environment $environment)
    {
        $this->template = $template;
        $this->environment = $environment;
    }

    /**
     *
     */
    public function render(array $context = []): string
    {
        return $this->environment->render($this->template, $context);
    }
}
