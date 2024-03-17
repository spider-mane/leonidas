<?php

namespace Leonidas\Library\Admin\Component\Abstracts;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Core\View\Twig\AdminFunctionsExtension;
use Leonidas\Library\Core\View\Twig\PrettyDebugExtension;
use Leonidas\Library\Core\View\Twig\SkyHooksExtension;
use Leonidas\Library\Core\View\Twig\StringHelperExtension;
use Leonidas\Library\Core\View\Twig\ViewLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractTwigView implements ViewInterface
{
    private const DEPTH = 5;

    private const CACHE_DIR = '/var/cache/views/twig';

    private const EXTENSIONS = [
        AdminFunctionsExtension::class,
        PrettyDebugExtension::class,
        SkyHooksExtension::class,
        StringHelperExtension::class,
    ];

    protected string $view;

    private static Environment $env;

    final public function render(array $context = []): string
    {
        return $this->getEnv()->render($this->getView(), $context);
    }

    private function getView(): string
    {
        return $this->view;
    }

    private function getEnv(): Environment
    {
        return self::$env ??= $this->buildEnv();
    }

    private function buildEnv(): Environment
    {
        $loader = new ViewLoader(
            new FilesystemLoader(['views'], $this->abspath())
        );

        $env = new Environment($loader, [
            'autoescape' => false,
            'cache' => $this->abspath(self::CACHE_DIR),
            'debug' => constant('LEONIDAS_DEVELOPMENT') ?? false,
        ]);

        foreach (self::EXTENSIONS as $extension) {
            $env->addExtension(new $extension());
        }

        return $env;
    }

    private function abspath(string $sub = ''): string
    {
        return dirname(__DIR__, self::DEPTH) . $sub;
    }
}
