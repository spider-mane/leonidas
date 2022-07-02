<?php

namespace Leonidas\Library\Admin\Component\Abstracts;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Core\View\Twig\AdminFunctionsExtension;
use Leonidas\Library\Core\View\Twig\PrettyDebugExtension;
use Leonidas\Library\Core\View\Twig\SkyHooksExtension;
use Leonidas\Library\Core\View\Twig\StringHelperExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractTwigView implements ViewInterface
{
    protected const EXTENSIONS = [
        PrettyDebugExtension::class,
        AdminFunctionsExtension::class,
        SkyHooksExtension::class,
        StringHelperExtension::class,
    ];

    private const DEPTH = 5;

    protected Environment $env;

    protected string $template;

    public function render(array $context = []): string
    {
        return $this->getEnv()->render($this->getTemplate(), $context);
    }

    protected function getEnv(): Environment
    {
        return $this->env ??= $this->buildEnv();
    }

    protected function getTemplate(): string
    {
        return $this->template;
    }

    protected function buildEnv(): Environment
    {
        $loader = new FilesystemLoader(['views'], $this->abspath());
        $env = new Environment($loader, [
            'autoescape' => false,
            'cache' => $this->abspath('/storage/cache/views/twig'),
            'debug' => constant('LEONIDAS_DEVELOPMENT') ?? false,
        ]);

        foreach (static::EXTENSIONS as $extension) {
            $env->addExtension(new $extension());
        }

        return $env;
    }

    protected function abspath(string $sub = ''): string
    {
        return dirname(__DIR__, self::DEPTH) . $sub;
    }
}
