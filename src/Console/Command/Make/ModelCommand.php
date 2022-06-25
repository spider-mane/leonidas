<?php

namespace Leonidas\Console\Command\Make;

use DirectoryIterator;
use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelComponentFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends HopliteCommand
{
    protected const CORE_FILE_METHODS = [
        'makeModelFiles',
        'makeCollectionFiles',
        'makeRepositoryFiles',
    ];

    protected const SUPPORT_FILE_METHODS = [
        'makeFactoryFiles',
        'makeAccessProviderFiles',
    ];

    protected const VALID_TEMPLATES = [
        'post',
        'post:h',
        'attachment',
        'term',
        'term:h',
        'user',
    ];

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
            ->addOption('design', 'd', InputOption::VALUE_NONE, 'Generate interfaces only')
            ->addOption('build', 'b', InputOption::VALUE_NONE, 'Generate classes using interfaces as guide')
            ->addOption('replace', 'r', InputOption::VALUE_OPTIONAL, '');
    }

    protected function handle(): int
    {
        $template = $this->input->getOption('template');

        if ($this->isValidTemplate($template)) {
            $status = $this->makeFiles($template);
        } else {
            $this->output->error("Value \"{$template}\" is not an accepted value for template");

            $status = self::FAILURE;
        }

        return $status;
    }

    protected function isValidTemplate(string $template): bool
    {
        return in_array($template, static::VALID_TEMPLATES);
    }

    protected function makeFiles(string $template): int
    {
        $model = $this->convert($this->input->getArgument('model'))->toPascal();
        $namespace = $this->configurableOption('namespace', 'make.model.namespace');
        $contracts = $this->configurableOption('contracts', 'make.model.contracts');

        $factory = $this->getComponentFactory($model, $namespace, $contracts, $template);
        $paths = $this->getOutputPaths($model, $namespace, $contracts);
        $action = $this->resolveRequestedAction();

        foreach (static::CORE_FILE_METHODS as $method) {
            $status = $this->$method($factory, $action, $paths);

            if (self::SUCCESS !== $status) {
                return $status;
            }
        }

        if ('interfaces' !== $action) {
            foreach (static::SUPPORT_FILE_METHODS as $method) {
                $status = $this->$method($factory, $paths);

                if (self::SUCCESS !== $status) {
                    return $status;
                }
            }
        }

        $this->output->success("Successfully created model files");

        return self::SUCCESS;
    }

    protected function getComponentFactory(
        string $model,
        string $namespace,
        string $contracts,
        string $template
    ): ModelComponentFactory {
        $entity = $this->input->getArgument('entity');
        $single = $this->input->getArgument('single');
        $plural = $this->input->getArgument('plural');

        $namespace = $this->getNamespaceFromPath($namespace) . '\\' . $model;
        $contracts = $this->getNamespaceFromPath($contracts) . '\\' . $model;
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

        return $factory;
    }

    protected function getOutputPaths(string $model, string $namespace, string $contracts): array
    {
        return [
            'interfaces' => $contracts . DIRECTORY_SEPARATOR . $model,
            'classes' => $namespace = $namespace . DIRECTORY_SEPARATOR . $model,
            'abstracts' => $this->resolveAbstractDir($namespace),
        ];
    }

    protected function resolveRequestedAction(): string
    {
        if ($this->input->getOption('design')) {
            return 'interfaces';
        } elseif ($this->input->getOption('build')) {
            return 'classes';
        } else {
            return 'complete';
        }
    }

    protected function setupTestDir(): array
    {
        $playground = $this->external('/.playground/model');

        if ($this->filesystem->exists($playground)) {
            // $this->filesystem->remove($playground);
        } else {
            $this->filesystem->mkdir($playground);
        }

        foreach (new DirectoryIterator($playground) as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if (!str_ends_with($file->getBasename(), 'Interface.php')) {
                $this->filesystem->remove($file->getPathname());
            } else {
                require $file->getPathname();
            }
        }

        return [
            'interfaces' => $playground,
            'classes' => $playground,
            'abstracts' => $playground,
        ];
    }

    protected function makeModelFiles(ModelComponentFactory $factory, string $action, array $paths): int
    {
        $interface = $factory->getModelInterfacePrinter();
        $class = $factory->getModelPrinter();

        $interfaceFile = $this->phpFile($paths['interfaces'], $interface->getClass());
        $classFile = $this->phpFile($paths['classes'], $class->getClass());

        if ('interfaces' === $action || 'complete' === $action) {
            $this->writeFile($interfaceFile, $interface->printFile());
        } elseif ('classes' === $action) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->writeFile($classFile, $class->printFromType());
        }

        if ('complete' === $action) {
            $this->writeFile($classFile, $class->printFile());
        }

        return self::SUCCESS;
    }

    protected function makeCollectionFiles(ModelComponentFactory $factory, string $action, array $paths): int
    {
        $isPost = $factory->isPostTemplate();

        $interface = $factory->getCollectionInterfacePrinter();
        $collection = $isPost
            ? $factory->getChildCollectionPrinter()
            : $factory->getCollectionPrinter();
        $abstract = $factory->getAbstractCollectionPrinter();
        $query = $factory->getChildQueryPrinter();

        $interfaceFile = $this->phpFile($paths['interfaces'], $interface->getClass());
        $collectionFile = $this->phpFile($paths['classes'], $collection->getClass());
        $abstractFile = $this->phpFile($paths['abstracts'], $abstract->getClass());
        $queryFile = $this->phpFile($paths['classes'], $query->getClass());

        if ('interfaces' === $action || 'complete' === $action) {
            $this->writeFile($interfaceFile, $interface->printFile());
        } elseif ('classes' === $action) {
            if (!interface_exists($interface->getClassFqn())) {
                $this->output->error("Interface {$interface->getClassFqn()} does not exist");

                return self::INVALID;
            }

            if ($isPost) {
                $this->writeFile($abstractFile, $abstract->printFromType());
                $this->writeFile($collectionFile, $collection->printFile());
                $this->writeFile($queryFile, $query->printFile());
            } else {
                $this->writeFile($collectionFile, $collection->printFromType());
            }
        }

        if ('complete' === $action) {
            $this->writeFile($collectionFile, $collection->printFile());

            if ($isPost) {
                $this->writeFile($abstractFile, $abstract->printFile());
                $this->writeFile($queryFile, $query->printFile());
            }
        }

        return self::SUCCESS;
    }

    protected function makeRepositoryFiles(ModelComponentFactory $factory, string $action, array $paths): int
    {
        $interface = $factory->getRepositoryInterfacePrinter();
        $class = $factory->getRepositoryPrinter();

        $interfaceFile = $this->phpFile($paths['interfaces'], $interface->getClass());
        $classFile = $this->phpFile($paths['classes'], $class->getClass());

        if ('interfaces' === $action || 'complete' === $action) {
            $this->writeFile($interfaceFile, $interface->printFile());
        } elseif ('classes' === $action) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->writeFile($classFile, $class->printFromType());
        }

        if ('complete' === $action) {
            $this->writeFile($classFile, $class->printFile());
        }

        return self::SUCCESS;
    }

    protected function makeFactoryFiles(ModelComponentFactory $factory, array $paths): int
    {
        $model = $factory->getModelConverterPrinter();
        $collection = $factory->getCollectionFactoryPrinter();

        $modelFile = $this->phpFile($paths['classes'], $model->getClass());
        $collectionFile = $this->phpFile($paths['classes'], $collection->getClass());

        $this->writeFile($modelFile, $model->printFile());
        $this->writeFile($collectionFile, $collection->printFile());

        if ($factory->isPostTemplate()) {
            $query = $factory->getQueryFactoryPrinter();
            $queryFile = $this->phpFile($paths['classes'], $query->getClass());

            $this->writeFile($queryFile, $query->printFile());
        }

        return self::SUCCESS;
    }

    protected function makeAccessProviderFiles(ModelComponentFactory $factory, array $paths): int
    {
        $get = $factory->getGetAccessProviderPrinter();
        $set = $factory->getSetAccessProviderPrinter();

        $getFile = $this->phpFile($paths['classes'], $get->getClass());
        $setFile = $this->phpFile($paths['classes'], $set->getClass());

        $this->writeFile($getFile, $get->printFile());
        $this->writeFile($setFile, $set->printFile());

        if ($factory->isPostTemplate()) {
            $tag = $factory->getTagAccessProviderPrinter();
            $tagFile = $this->phpFile($paths['classes'], $tag->getClass());

            $this->writeFile($tagFile, $tag->printFile());
        }

        return self::SUCCESS;
    }
}
