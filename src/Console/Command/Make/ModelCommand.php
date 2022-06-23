<?php

namespace Leonidas\Console\Command\Make;

use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelComponentFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ModelCommand extends HopliteCommand
{
    protected static $defaultName = 'make:model';

    protected function configure()
    {
        $this
            ->addArgument('component', InputArgument::OPTIONAL, 'The component set to generate')
            ->addOption('model', 'm', InputOption::VALUE_REQUIRED, '')
            ->addOption('entity', 'e', InputOption::VALUE_REQUIRED, '')
            ->addOption('single', 's', InputOption::VALUE_REQUIRED, '')
            ->addOption('plural', 'p', InputOption::VALUE_REQUIRED, '')
            ->addOption('template', 't', InputOption::VALUE_OPTIONAL, '')
            ->addOption('namespace', 'l', InputOption::VALUE_OPTIONAL, '')
            ->addOption('contracts', 'c', InputOption::VALUE_OPTIONAL, '')
            ->addOption('abstracts', 'a', InputOption::VALUE_OPTIONAL, '')
            ->addOption('replace', 'r', InputOption::VALUE_OPTIONAL, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->runTests($input, $output);

        return self::SUCCESS;
    }

    protected function runTests(InputInterface $input, OutputInterface $output): void
    {
        $playground = $this->external('/.playground/model');

        if ($this->filesystem->exists($playground)) {
            $this->filesystem->remove($playground);
        }

        $this->filesystem->mkdir($playground);

        $model = $input->getOption('model');
        $entity = $input->getOption('entity');
        $single = $input->getOption('single');
        $plural = $input->getOption('plural');
        $template = $input->getOption('template') ?? 'post';

        $namespace = $this->getNamespaceFromPath(
            $this->fallbackOption($input, 'namespace', 'make.model.namespace')
        );
        $contracts = $this->getNamespaceFromPath(
            $this->fallbackOption($input, 'contracts', 'make.model.contracts')
        );
        $abstracts = $this->config('abstract_dir', true)
            ? $namespace . '\\Abstracts'
            : $namespace;

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

        $this->testCollection($playground, $factory);
        $this->testRepository($playground, $factory);
        $this->testModel($playground, $factory);
        $this->testFactories($playground, $factory);
        $this->testAccessProviders($playground, $factory);
    }

    protected function testAccessProviders(string $playground, ModelComponentFactory $factory): void
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
    }

    protected function testFactories(string $playground, ModelComponentFactory $factory): void
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
    }

    protected function testModel(string $playground, ModelComponentFactory $factory): void
    {
        $interface = $factory->getModelInterfacePrinter();
        $class = $factory->getModelPrinter();

        $this->printPhp($interface = $interface->printFile());
        $this->writeFile($playground . '/model-interface.php', $interface);

        $this->printPhp($class = $class->printFile());
        $this->writeFile($playground . '/model-class.php', $class);
    }

    protected function testRepository(string $playground, ModelComponentFactory $factory): void
    {
        $interface = $factory->getRepositoryInterfacePrinter();
        $class = $factory->getRepositoryPrinter();

        $this->printPhp($interface = $interface->printFile());
        $this->writeFile($playground . '/repository-interface.php', $interface);

        $this->printPhp($class = $class->printFile());
        $this->writeFile($playground . '/repository-class.php', $class);
    }

    protected function testCollection(string $playground, ModelComponentFactory $factory): void
    {
        $interface = $factory->getCollectionInterfacePrinter();

        $this->printPhp($interface = $interface->printFile());
        $this->writeFile($playground . '/collection-interface.php', $interface);

        if ($factory->isPostTemplate()) {
            $abstract = $factory->getAbstractCollectionPrinter();
            $collection = $factory->getChildCollectionPrinter();
            $query = $factory->getChildQueryPrinter();

            $this->printPhp($abstract = $abstract->printFile());
            $this->writeFile($playground . '/collection-abstract.php', $abstract);

            $this->printPhp($query = $query->printFile());
            $this->writeFile($playground . '/collection-query.php', $query);
        } else {
            $collection = $factory->getCollectionPrinter();
        }

        $this->printPhp($collection = $collection->printFile());
        $this->writeFile($playground . '/collection-collection.php', $collection);
    }
}
