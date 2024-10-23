<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Environment as TwigEnvironment;

class Environment extends TwigEnvironment
{
    public function __construct(protected string $routes)
    {
        //
    }

    public function route(string $name, array $context = []): string
    {
        return $this->render("{$this->routes}.{$name}", $context);
    }
}
