<?php

namespace Leonidas\Library\Core\View\Twig;

use Composer\InstalledVersions;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\CoreExtension;
use Twig\TwigFunction;

class PartialLoaderExtension extends AbstractExtension
{
    protected string $partials = 'includes';

    public function getFunctions()
    {
        return [
            new TwigFunction('from', $this->resolveFrom(...)),
            new TwigFunction('partial', $this->resolvePartial(...)),
            new TwigFunction('insert', $this->includePartial(...), [
                'needs_environment' => true,
                'needs_context' => true,
            ]),
        ];
    }

    protected function resolveFrom(string $from, string $get, int $depth = 1): string
    {
        $base = str_replace(
            ['@__main__/', '/'],
            ['', '.'],
            dirname($from, $depth)
        );

        return "{$base}.{$get}";
    }

    protected function resolvePartial(string $from, string $get, int $depth = 1): string
    {
        return $this->resolveFrom($from, "{$this->partials}.{$get}", $depth);
    }

    protected function includePartial(
        Environment $env,
        array $context,
        string $from,
        string $get,
        array $variables = [],
        int $depth = 1,
        bool $withContext = true,
        bool $ignoreMissing = false,
        bool $sandboxed = false
    ) {
        $template = $this->resolvePartial($from, $get, $depth);

        return $this->include(
            $env,
            $context,
            $template,
            $variables,
            $withContext,
            $ignoreMissing,
            $sandboxed
        );
    }

    protected function include(
        Environment $env,
        $context,
        $template,
        $variables = [],
        $withContext = true,
        $ignoreMissing = false,
        $sandboxed = false
    ) {
        $twig = InstalledVersions::getPrettyVersion('twig/twig');

        return version_compare($twig, '3.9', '>=')
            ? CoreExtension::include(...func_get_args())
            : twig_include(...func_get_args());
    }
}
