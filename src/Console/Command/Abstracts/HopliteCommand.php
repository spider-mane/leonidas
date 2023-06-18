<?php

namespace Leonidas\Console\Command\Abstracts;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleHighlighter\Highlighter;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use WebTheory\Config\Config;

abstract class HopliteCommand extends Command
{
    use ConvertsCaseTrait;

    protected Config $config;

    protected InputInterface $input;

    protected SymfonyStyle $output;

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

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = new SymfonyStyle($input, $output);

        return parent::run($this->input, $this->output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->handle();
    }

    protected function config(string $key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    protected function composer(string $key, $default = null)
    {
        return $this->composerConfig->get($key, $default);
    }

    protected function pathToNamespace(string $path, string $extra = ''): string
    {
        foreach ($this->composer('autoload.psr-4') as $namespace => $dir) {
            if (str_starts_with($path, $dir)) {
                $local = str_replace([$dir, '/'], ['', '\\'], $path);
                $extra = $extra ? '\\' . $extra : '';

                return $namespace . $local . $extra;
            }
        }

        throw new RuntimeException(
            'Could not find namespace in composer.json that corresponds with path: ' . $path
        );
    }

    protected function resolveAbstractNamespace(string $namespace): string
    {
        return $this->config('abstract_dir', true)
            ? $namespace . '\\Abstracts'
            : $namespace;
    }

    protected function resolveAbstractDir(string $dir): string
    {
        return $this->config('abstract_dir', true)
            ? $dir . DIRECTORY_SEPARATOR . 'Abstracts'
            : $dir;
    }

    protected function configurableArgument(string $option, string $configKey, $default = null)
    {
        return $this->input->getArgument($option)
            ?? $this->config($configKey, $default);
    }

    protected function configurableOption(string $option, string $configKey, $default = null)
    {
        return $this->input->getOption($option)
            ?? $this->config($configKey, $default);
    }

    protected function internal(string $path = ''): string
    {
        return dirname(__DIR__, 2) . $path;
    }

    protected function external(string $path = ''): string
    {
        return getcwd() . $path;
    }

    protected function printPhp(string $code): void
    {
        echo $this->highlighter->getWholeFile($code);
    }

    protected function writeFile(string $path, string $content, bool $replace = false): void
    {
        if (!$this->filesystem->exists($path) || $replace) {
            $this->filesystem->dumpFile($path, $content);
        } else {
            $this->output->text("File $path already exists");
        }
    }

    protected function writePhpFile(string $path, string $name, string $content, bool $replace = false): void
    {
        $this->writeFile($this->phpFile($path, $name), $content, $replace);
    }

    protected function writePhpFileRel(string $path, string $name, string $content, bool $replace = false): void
    {
        $this->writeFile($this->phpFileRel($path, $name), $content, $replace);
    }

    protected function phpFile(string $path, string $name): string
    {
        return $path . DIRECTORY_SEPARATOR . $name . '.php';
    }

    protected function phpFileRel(string $path, string $name): string
    {
        return $this->phpFile($this->external(DIRECTORY_SEPARATOR . $path), $name);
    }

    abstract protected function handle(): int;
}
