<?php

namespace Leonidas\Console\Command;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use Noodlehaus\Config;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleHighlighter\Highlighter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;

abstract class HopliteCommand extends Command
{
    use ConvertsCaseTrait;

    protected Config $config;

    protected Config $composerConfig;

    protected Filesystem $filesystem;

    protected Highlighter $highlighter;

    public function __construct(string $name = null)
    {
        $this->config = new Config($this->external('/hoplite.yml'));
        $this->composerConfig = new Config($this->external('/composer.json'));
        $this->filesystem = new Filesystem();
        $this->highlighter = new Highlighter(new ConsoleColor());
        $this->caseConverter = new CaseConverter();

        parent::__construct($name);
    }

    protected function config(string $key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    protected function composer(string $key, $default = null)
    {
        return $this->composerConfig->get($key, $default);
    }

    protected function getNamespaceFromPath(string $path): string
    {
        // todo: match completely
        $namespaces = array_flip($this->composer('autoload.psr-4'));
        $parts = explode('/', $path);
        $entry = array_shift($parts);
        $base = $namespaces[$entry . '/'];

        return $base . implode('\\', $parts);
    }

    protected function getPathFromNamespace(string $namespace): string
    {
        // todo: match completely
        $namespaces = $this->composer('autoload.psr-4');
        $parts = explode('\\', $namespace);
        $entry = array_shift($parts);
        $base = $namespaces[$entry . '\\'];

        return $base . implode('/', $parts);
    }

    protected function fallbackArgument(InputInterface $input, string $option, string $configKey, $default = null)
    {
        return $input->getArgument($option) ?? $this->config($configKey, $default);
    }

    protected function fallbackOption(InputInterface $input, string $option, string $configKey, $default = null)
    {
        return $input->getOption($option) ?? $this->config($configKey, $default);
    }

    protected function internal(string $path = ''): string
    {
        return dirname(__DIR__, 1) . $path;
    }

    protected function external(string $path = ''): string
    {
        return getcwd() . $path;
    }

    protected function printPhp(string $code): void
    {
        echo $this->highlighter->getWholeFile($code);
    }

    protected function writeFile(string $path, string $content): void
    {
        $this->filesystem->dumpFile($path, $content);
    }
}
