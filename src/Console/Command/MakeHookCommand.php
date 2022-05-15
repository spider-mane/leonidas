<?php

namespace Leonidas\Console\Command;

use Jawira\CaseConverter\CaseConverter;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeHookCommand extends Hoplite
{
    use ConvertsCaseTrait;

    protected const STUB_NAMESPACE = 'Leonidas\\Console\\Stubs\\Hook';

    protected static $defaultName = 'make:hook';

    protected static $defaultDescription = 'Creates a hook helper class';

    protected function configure(): void
    {
        $this
            ->addArgument('tag', InputArgument::REQUIRED)
            ->addArgument('type', InputArgument::OPTIONAL, 'The type of hook to create', 'action')
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL);
    }

    protected function init(): void
    {
        $this->caseConverter = new CaseConverter();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->init();

        $config = $this->getConfig();

        $tag = $input->getArgument('tag');
        $type = $input->getArgument('type');
        $converted = $this->convert($tag)->toPascal();

        $parts = explode('/', $config['hook']['path']);
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

        return Command::SUCCESS;
    }

    protected function getTemplate(string $type): string
    {
        return file_get_contents($this->getTemplateFile($type));
    }

    protected function getTemplateFile(string $type): string
    {
        return $this->path('/Stubs/Hook/TargetsDummy' . ucfirst($type) . 'Hook.php');
    }
}
