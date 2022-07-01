<?php

namespace Leonidas\Console\Command;

use DirectoryIterator;
use Leonidas\Console\Command\Abstracts\HopliteCommand;
use Leonidas\Console\Library\Printer\Model\ModelComponentFactory;
use Leonidas\Console\Library\Printer\Model\PsrPrinterFactory;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Post\AttachmentEntityManager;
use Leonidas\Library\System\Schema\Post\PostEntityManager;
use Leonidas\Library\System\Schema\Term\TermEntityManager;
use Leonidas\Library\System\Schema\User\UserEntityManager;
use Nette\PhpGenerator\PhpFile;
use ReflectionClass;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModelCommand extends HopliteCommand
{
    public const VALID_TEMPLATES = [
        'post',
        'post:h',
        'attachment',
        'term',
        'term:h',
        'user',
    ];

    protected const CORE_FILE_METHODS = [
        'model' => 'makeModelFiles',
        'collection' => 'makeCollectionFiles',
        'repository' => 'makeRepositoryFiles',
    ];

    protected const SUPPORT_FILE_METHODS = [
        'factories' => 'makeFactoryFiles',
        'access' => 'makeAccessProviderFiles',
        'registration' => 'updateRegistrationClass',
    ];

    protected static $defaultName = 'make:model';

    protected function configure()
    {
        $this
            ->addArgument('model', InputArgument::REQUIRED, '')
            ->addArgument('entity', InputArgument::REQUIRED, '')
            ->addArgument('single', InputArgument::REQUIRED, '')
            ->addArgument('plural', InputArgument::REQUIRED, '')
            ->addArgument('components', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, '')
            ->addOption('namespace', 's', InputOption::VALUE_OPTIONAL, '')
            ->addOption('contracts', 'c', InputOption::VALUE_OPTIONAL, '')
            ->addOption('abstracts', 'a', InputOption::VALUE_NONE, '')
            ->addOption('template', 't', InputOption::VALUE_REQUIRED, '', 'post')
            ->addOption('registration', 'r', InputOption::VALUE_REQUIRED, '')
            ->addOption('design', 'd', InputOption::VALUE_NONE, 'Generate interfaces only')
            ->addOption('build', 'b', InputOption::VALUE_NONE, 'Generate classes using interfaces as guide')
            ->addOption('force', 'f', InputOption::VALUE_NONE, '');
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

        $force = $this->input->getOption('force');

        foreach ($this->resolveComponents('core') as $method) {
            $status = $this->$method($factory, $action, $paths, $force);

            if (self::SUCCESS !== $status) {
                return $status;
            }
        }

        if ('interfaces' !== $action) {
            foreach ($this->resolveComponents('support') as $method) {
                $status = $this->$method($factory, $paths, $force);

                if (self::SUCCESS !== $status) {
                    return $status;
                }
            }
        }

        $this->output->success("Successfully created model files");

        return self::SUCCESS;
    }

    protected function resolveComponents(string $set): array
    {
        $set = constant(
            sprintf('%s::%s_FILE_METHODS', static::class, strtoupper($set))
        );

        if (!$components = $this->input->getArgument('components')) {
            return $set;
        }

        return array_filter(
            $set,
            fn ($method) => in_array($method, $components),
            ARRAY_FILTER_USE_KEY
        );
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

        $namespace = $this->pathToNamespace($namespace, $model);
        $contracts = $this->pathToNamespace($contracts, $model);
        $abstracts = $this->resolveAbstractNamespace($namespace);

        return ModelComponentFactory::build([
            'model' => $model,
            'namespace' => $namespace,
            'contracts' => $contracts,
            'abstracts' => $abstracts,
            'entity' => $entity,
            'single' => $single,
            'plural' => $plural,
            'template' => $template,
        ]);
    }

    protected function getOutputPaths(string $model, string $namespace, string $contracts): array
    {
        return [
            'interfaces' => $contracts . DIRECTORY_SEPARATOR . $model,
            'classes' => $namespace = $namespace . DIRECTORY_SEPARATOR . $model,
            'abstracts' => $this->resolveAbstractDir($namespace),
        ];
    }

    protected function setupTestDir(): array
    {
        $playground = $this->external('/.playground/model');

        if ($this->filesystem->exists($playground)) {
            foreach (new DirectoryIterator($playground) as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                $isInterface = str_ends_with($file->getBasename(), 'Interface.php');
                $isRegistrar = $file->getBasename() === 'RegisterModelServices.php';

                if (!($isInterface || $isRegistrar)) {
                    // $this->filesystem->remove($file->getPathname());
                }

                if ($isInterface) {
                    require $file->getPathname();
                }
            }

            // $this->filesystem->remove($playground);
        } else {
            $this->filesystem->mkdir($playground);
        }

        $registrar = 'RegisterModelServices.php';

        $this->filesystem->copy(
            $this->external("/src/Framework/Bootstrap/{$registrar}"),
            "{$playground}/{$registrar}"
        );

        foreach (['Contracts', 'Library'] as $namespace) {
            $this->filesystem->remove(
                $this->external('/src/' . $namespace . '/System/Model/Test')
            );
        }

        return [
            'interfaces' => $playground,
            'classes' => $playground,
            'abstracts' => $playground,
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

    protected function makeModelFiles(ModelComponentFactory $factory, string $action, array $paths, bool $force): int
    {
        $interface = $factory->getModelInterfacePrinter();
        $class = $factory->getModelPrinter();

        $interfaceFile = $this->phpFile($paths['interfaces'], $interface->getClass());
        $classFile = $this->phpFile($paths['classes'], $class->getClass());

        if ('interfaces' === $action || 'complete' === $action) {
            $this->writeFile($interfaceFile, $interface->printFile(), $force);
        } elseif ('classes' === $action) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->writeFile($classFile, $class->printFromType(), $force);
        }

        if ('complete' === $action) {
            $this->writeFile($classFile, $class->printFile(), $force);
        }

        return self::SUCCESS;
    }

    protected function makeCollectionFiles(ModelComponentFactory $factory, string $action, array $paths, bool $force): int
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
            $this->writeFile($interfaceFile, $interface->printFile(), $force);
        } elseif ('classes' === $action) {
            if (!interface_exists($interface->getClassFqn())) {
                $this->output->error("Interface {$interface->getClassFqn()} does not exist");

                return self::INVALID;
            }

            if ($isPost) {
                $this->writeFile($abstractFile, $abstract->printFromType(), $force);
                $this->writeFile($collectionFile, $collection->printFile(), $force);
                $this->writeFile($queryFile, $query->printFile(), $force);
            } else {
                $this->writeFile($collectionFile, $collection->printFromType(), $force);
            }
        }

        if ('complete' === $action) {
            $this->writeFile($collectionFile, $collection->printFile(), $force);

            if ($isPost) {
                $this->writeFile($abstractFile, $abstract->printFile(), $force);
                $this->writeFile($queryFile, $query->printFile(), $force);
            }
        }

        return self::SUCCESS;
    }

    protected function makeRepositoryFiles(ModelComponentFactory $factory, string $action, array $paths, bool $force): int
    {
        $interface = $factory->getRepositoryInterfacePrinter();
        $class = $factory->getRepositoryPrinter();

        $interfaceFile = $this->phpFile($paths['interfaces'], $interface->getClass());
        $classFile = $this->phpFile($paths['classes'], $class->getClass());

        if ('interfaces' === $action || 'complete' === $action) {
            $this->writeFile($interfaceFile, $interface->printFile(), $force);
        } elseif ('classes' === $action) {
            if (!interface_exists($interfaceFqn = $interface->getClassFqn())) {
                $this->output->error("Interface {$interfaceFqn} does not exist");

                return self::INVALID;
            }

            $this->writeFile($classFile, $class->printFromType(), $force);
        }

        if ('complete' === $action) {
            $this->writeFile($classFile, $class->printFile(), $force);
        }

        return self::SUCCESS;
    }

    protected function makeFactoryFiles(ModelComponentFactory $factory, array $paths, bool $force): int
    {
        $model = $factory->getModelConverterPrinter();
        $collection = $factory->getCollectionFactoryPrinter();

        $modelFile = $this->phpFile($paths['classes'], $model->getClass());
        $collectionFile = $this->phpFile($paths['classes'], $collection->getClass());

        $this->writeFile($modelFile, $model->printFile(), $force);
        $this->writeFile($collectionFile, $collection->printFile(), $force);

        if ($factory->isPostTemplate()) {
            $query = $factory->getQueryFactoryPrinter();
            $queryFile = $this->phpFile($paths['classes'], $query->getClass());

            $this->writeFile($queryFile, $query->printFile(), $force);
        }

        return self::SUCCESS;
    }

    protected function makeAccessProviderFiles(ModelComponentFactory $factory, array $paths, bool $force): int
    {
        $get = $factory->getGetAccessProviderPrinter();
        $set = $factory->getSetAccessProviderPrinter();

        $getFile = $this->phpFile($paths['classes'], $get->getClass());
        $setFile = $this->phpFile($paths['classes'], $set->getClass());

        $this->writeFile($getFile, $get->printFile(), $force);
        $this->writeFile($setFile, $set->printFile(), $force);

        if ($factory->isPostTemplate()) {
            $tag = $factory->getTagAccessProviderPrinter();
            $tagFile = $this->phpFile($paths['classes'], $tag->getClass());

            $this->writeFile($tagFile, $tag->printFile(), $force);
        }

        return self::SUCCESS;
    }

    public function updateRegistrationClass(ModelComponentFactory $factory, array $paths, bool $force): int
    {
        $model = $factory->getModelConverterPrinter();
        $collection = $factory->getCollectionFactoryPrinter();
        $query = $factory->getQueryFactoryPrinter();
        $repository = $factory->getRepositoryPrinter();
        $iRepository = $factory->getRepositoryInterfacePrinter();

        $name = $factory->getSingle();
        $entity = $factory->getEntity();
        $managerFqn = [
            'post' => PostEntityManager::class,
            'post:h' => PostEntityManager::class,
            'attachment' => AttachmentEntityManager::class,
            'term' => TermEntityManager::class,
            'term:h' => TermEntityManager::class,
            'user' => UserEntityManager::class,
        ][$factory->getTemplate()];
        $manager = (new ReflectionClass($managerFqn))->getShortName();

        $boilerplate = [
            'post' => <<<PHP
            \$this->container->share({$model->getClass()}::class, fn () => new {$model->getClass()}(
                \$this->extension->get(AutoInvokerInterface::class)
            ));

            \$this->container->share({$query->getClass()}::class, fn () => new {$query->getClass()}(
                \$this->extension->get({$model->getClass()}::class),
            ));

            \$this->container->share({$iRepository->getClass()}::class, function () {
                return new {$repository->getClass()}(new {$manager}(
                    '{$entity}',
                    \$this->extension->get({$model->getClass()}::class),
                    new {$collection->getClass()}(),
                    \$this->extension->get({$query->getClass()}::class),
                ));
            });
            PHP,
            'default' => <<<PHP
            \$this->container->share({$model->getClass()}::class, fn () => new {$model->getClass()}(
                \$this->extension->get(AutoInvokerInterface::class)
            ));

            \$this->container->share({$iRepository->getClass()}::class, function () {
                \$converter = \$this->extension->get({$model->getClass()}::class);
                \$collection = new {$collection->getClass()}();
                \$manager = new {$manager}('{$entity}', \$converter, \$collection);

                return new {$repository->getClass()}(\$manager);
            });
            PHP
        ][$factory->isPostTemplate() ? 'post' : 'default'];

        $registrar = $this->configurableOption('registration', 'make.model.registration');

        $printer = PsrPrinterFactory::create();
        $file = PhpFile::fromCode(file_get_contents($registrar));

        $namespaces = $file->getNamespaces();
        $namespace = reset($namespaces);

        $namespace
            ->addUse(AutoInvokerInterface::class)
            ->addUse($managerFqn)
            ->addUse($model->getClassFqn())
            ->addUse($collection->getClassFqn())
            ->addUse($iRepository->getClassFqn())
            ->addUse($repository->getClassFqn());

        if ($factory->isPostTemplate()) {
            $namespace->addUse($query->getClassFqn());
        }

        $classes = $namespace->getClasses();
        $class = reset($classes);

        $constants = $class->getConstants();
        $models = $constants['MODELS'];
        $list = array_filter(explode(',', str_replace(
            ["\n", '[', ']', ' ', '\'', '"'],
            '',
            $models->getValue()
        )));

        $models->setValue(array_unique([...$list, $name]));

        $class->addMethod($name)
            ->setReturnType('void')
            ->setBody($boilerplate);

        $this->writeFile($registrar, $printer->printFile($file), true);

        return self::SUCCESS;
    }
}
