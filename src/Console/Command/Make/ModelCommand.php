<?php

namespace Leonidas\Console\Command\Make;

use DirectoryIterator;
use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelComponentFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends HopliteCommand
{
    protected static $defaultName = 'make:model';

    protected function configure()
    {
        $this
            ->addArgument('model', InputArgument::REQUIRED, '')
            ->addArgument('entity', InputArgument::REQUIRED, '')
            ->addArgument('single', InputArgument::REQUIRED, '')
            ->addArgument('plural', InputArgument::REQUIRED, '')
            ->addOption('namespace', 'l', InputOption::VALUE_OPTIONAL, '')
            ->addOption('contracts', 'c', InputOption::VALUE_OPTIONAL, '')
            ->addOption('abstracts', 'a', InputOption::VALUE_OPTIONAL, '')
            ->addOption('template', 't', InputOption::VALUE_REQUIRED, '', 'post')
            ->addOption('components', 'p', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'The component set to generate')
            ->addOption('only-interface', 'o', InputOption::VALUE_NONE, 'Generate interfaces only')
            ->addOption('from-interface', 'f', InputOption::VALUE_NONE, 'Generate classes using interfaces as guide')
            ->addOption('replace', 'r', InputOption::VALUE_OPTIONAL, '');
    }

    protected function handle(): int
    {
        $template = $this->input->getOption('template');

        if ($this->isValidTemplate($template)) {
            $status = $this->makeFiles($template);
        } else {
            $this->output->error("Template \"{$template}\" is not valid");

            $status = self::FAILURE;
        }

        return $status;
    }

    protected function isValidTemplate(string $template): bool
    {
        return in_array($template, [
            'post',
            'post:h',
            'attachment',
            'term',
            'term:h',
            'user',
        ]);
    }

    protected function setupTestDir(string $dir): void
    {
        if ($this->filesystem->exists($dir)) {
            // $this->filesystem->remove($playground);
        } else {
            $this->filesystem->mkdir($dir);
        }

        foreach (new DirectoryIterator($dir) as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if (!str_ends_with($file->getBasename(), '-interface.php')) {
                $this->filesystem->remove($file->getPathname());
            } else {
                require $file->getPathname();
            }
        }
    }

    protected function makeFiles(string $template): int
    {
        $playground = $this->external('/.playground/model');

        $this->setupTestDir($playground);

        $model = $this->input->getArgument('model');
        $entity = $this->input->getArgument('entity');
        $single = $this->input->getArgument('single');
        $plural = $this->input->getArgument('plural');

        $model = $this->convert($model)->toPascal();

        $namespace = $this->getNamespaceFromPath($this->configuredOption(
            'namespace',
            'make.model.namespace'
        )) . '\\' . $model;

        $contracts = $this->getNamespaceFromPath($this->configuredOption(
            'contracts',
            'make.model.contracts'
        )) . '\\' . $model;

        $abstracts = $this->resolveAbstractNamespace($namespace);

        $factory = ModelComponentFactory::build([
            'model' => $model,
            'namespace' => $namespace,
            'contracts' => $contracts,
            'abstracts' => $abstracts,
            'entity' => $entity,
            'single' => $single,
            'plural' => $plural,
            'template' => $template,
        ]);

        if ($this->input->getOption('only-interface')) {
            $build = 'interfaces';
        } elseif ($this->input->getOption('from-interface')) {
            $build = 'classes';
        } else {
            $build = 'complete';
        }

        $typed = [
            'makeModelFiles',
            'makeCollectionFiles',
            'makeRepositoryFiles',
        ];

        foreach ($typed as $method) {
            $status = $this->$method($playground, $factory, $build);

            if (self::SUCCESS !== $status) {
                return $status;
            }
        }

        $support = [
            'makeFactoryFiles',
            'makeAccessProviderFiles',
        ];

        if ('interfaces' !== $build) {
            foreach ($support as $method) {
                $status = $this->$method($playground, $factory);

                if (self::SUCCESS !== $status) {
                    return $status;
                }
            }
        }

        return self::SUCCESS;
    }

    protected function makeModelFiles(string $playground, ModelComponentFactory $factory, string $build): int
    {
        $interface = $factory->getModelInterfacePrinter();
        $class = $factory->getModelPrinter();

        if ('interfaces' === $build || 'complete' === $build) {
            $this->printPhp($output = $interface->printFile());
            $this->writeFile($playground . '/model-interface.php', $output);
        } elseif ('classes' === $build) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->printPhp($output = $class->printFromType());
            $this->writeFile($playground . '/model-class.php', $output);
        }

        if ('complete' === $build) {
            $this->printPhp($class = $class->printFile());
            $this->writeFile($playground . '/model-class.php', $class);
        }

        return self::SUCCESS;
    }

    protected function makeCollectionFiles(string $playground, ModelComponentFactory $factory, string $build): int
    {
        $isPost = $factory->isPostTemplate();

        $interface = $factory->getCollectionInterfacePrinter();
        $collection = $isPost
            ? $factory->getChildCollectionPrinter()
            : $factory->getCollectionPrinter();
        $abstract = $factory->getAbstractCollectionPrinter();
        $query = $factory->getChildQueryPrinter();

        if ('interfaces' === $build || 'complete' === $build) {
            $this->printPhp($output = $interface->printFile());
            $this->writeFile($playground . '/collection-interface.php', $output);
        } elseif ('classes' === $build) {
            if (!interface_exists($interface->getClassFqn())) {
                $this->output->error("Interface {$interface->getClassFqn()} does not exist");

                return self::INVALID;
            }

            if ($isPost) {
                $this->printPhp($output = $abstract->printFromType());
                $this->writeFile($playground . '/collection-abstract.php', $output);

                $this->printPhp($output = $collection->printFile());
                $this->writeFile($playground . '/collection-class.php', $output);

                $this->printPhp($output = $query->printFile());
                $this->writeFile($playground . '/collection-query.php', $output);
            } else {
                $this->printPhp($output = $collection->printFromType());
                $this->writeFile($playground . '/collection-class.php', $output);
            }
        }

        if ('complete' === $build) {
            $this->printPhp($output = $collection->printFile());
            $this->writeFile($playground . '/collection-class.php', $output);

            if ($isPost) {
                $this->printPhp($output = $abstract->printFile());
                $this->writeFile($playground . '/collection-abstract.php', $output);

                $this->printPhp($output = $query->printFile());
                $this->writeFile($playground . '/collection-query.php', $output);
            }
        }

        return self::SUCCESS;
    }

    protected function makeRepositoryFiles(string $playground, ModelComponentFactory $factory, string $build): int
    {
        $interface = $factory->getRepositoryInterfacePrinter();
        $class = $factory->getRepositoryPrinter();

        if ('interfaces' === $build || 'complete' === $build) {
            $this->printPhp($interface = $interface->printFile());
            $this->writeFile($playground . '/repository-interface.php', $interface);
        } elseif ('classes' === $build) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->printPhp($class = $class->printFromType());
            $this->writeFile($playground . '/repository-class.php', $class);
        }

        if ('complete' === $build) {
            $this->printPhp($class = $class->printFile());
            $this->writeFile($playground . '/repository-class.php', $class);
        }

        return self::SUCCESS;
    }

    protected function makeFactoryFiles(string $playground, ModelComponentFactory $factory): int
    {
        $model = $factory->getModelConverterPrinter();
        $collection = $factory->getCollectionFactoryPrinter();

        $this->printPhp($model = $model->printFile());
        $this->writeFile($playground . '/factory-model.php', $model);

        $this->printPhp($collection = $collection->printFile());
        $this->writeFile($playground . '/factory-collection.php', $collection);

        if ($factory->isPostTemplate()) {
            $query = $factory->getQueryFactoryPrinter();

            $this->printPhp($query = $query->printFile());
            $this->writeFile($playground . '/factory-query.php', $query);
        }

        return self::SUCCESS;
    }

    protected function makeAccessProviderFiles(string $playground, ModelComponentFactory $factory): int
    {
        $get = $factory->getGetAccessProviderPrinter();
        $set = $factory->getSetAccessProviderPrinter();

        $this->printPhp($get = $get->printFile());
        $this->writeFile($playground . '/access-get.php', $get);

        $this->printPhp($set = $set->printFile());
        $this->writeFile($playground . '/access-set.php', $set);

        if ($factory->isPostTemplate()) {
            $tag = $factory->getTagAccessProviderPrinter();

            $this->printPhp($tag = $tag->printFile());
            $this->writeFile($playground . '/access-tag.php', $tag);
        }

        return self::SUCCESS;
    }
}
