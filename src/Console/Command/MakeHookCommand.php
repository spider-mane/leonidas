<?php

namespace Leonidas\Console\Command;

use Leonidas\Console\Command\Abstracts\HopliteCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeHookCommand extends HopliteCommand
{
    protected const STUB_NAMESPACE = 'Leonidas\\Tasks\\Make\\Stubs\\Hook';

    protected static $defaultName = 'make:hook';

    protected static $defaultDescription = 'Creates a hook helper class';

    protected function configure(): void
    {
        $this
            ->addArgument('tag', InputArgument::REQUIRED)
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of hook to create', 'action')
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL);
    }

    protected function handle(): int
    {
        $tag = $this->input->getArgument('tag');
        $type = $this->input->getArgument('type');
        $converted = $this->convert($tag)->toPascal();

        $parts = explode('/', $this->config('make.hook.path'));
        $root = array_shift($parts);
        $namespace = implode('\\', $parts);
        $dir = $root . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array_slice($parts, 1));
        $filename = 'Targets' . $converted . 'Hook.php';
        $file = getcwd() . '/' . $dir . '/' . $filename;

        $template = $this->getTemplate($type);

        $replacements = [
            static::STUB_NAMESPACE => $namespace,
            'Dummy' . ucfirst($type) => $converted,
            'dummy_' . strtolower($type) => $tag,
        ];

        foreach ($replacements as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        if (!file_exists($file)) {
            touch($file);
        }

        file_put_contents($file, $template);

        return self::SUCCESS;
    }

    protected function getTemplate(string $type): string
    {
        return file_get_contents($this->getTemplateFile($type));
    }

    protected function getTemplateFile(string $type): string
    {
        return $this->external(
            '/src/Tasks/Make/Stubs/Hook/TargetsDummy' . ucfirst($type) . 'Hook.php'
        );
    }
}
