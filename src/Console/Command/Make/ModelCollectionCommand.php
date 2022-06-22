<?php

namespace Leonidas\Console\Command\Make;

use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelCollectionFactoryPrinter;
use Leonidas\Console\Library\ModelCollectionsFactory;
use Leonidas\Console\Library\ModelConverterPrinter;
use Leonidas\Console\Library\ModelInterfacePrinter;
use Leonidas\Console\Library\ModelPrinter;
use Leonidas\Console\Library\ModelQueryFactoryPrinter;
use Leonidas\Console\Library\ModelRepositoryInterfacePrinter;
use Leonidas\Console\Library\ModelRepositoryPrinter;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelCollectionCommand extends HopliteCommand
{
    protected static $defaultName = 'make:model-collection';

    protected function configure()
    {
        // $this
        //     ->addArgument('model', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->runTests();

        return 0;
    }

    protected function runTests(): void
    {
        $playground = getcwd() . '/.playground/model';

        if (!is_dir($playground)) {
            mkdir($playground, 0777, true);
        }

        $this->testCollection($playground);
        $this->testRepository($playground);
        $this->testModel($playground);
        $this->testFactories($playground);
    }

    protected function testFactories(string $playground): void
    {
        $namespace = 'Leonidas\Library\System\Model\Post';

        $collection = new ModelCollectionFactoryPrinter(
            $namespace,
            'PostCollectionFactory',
            $namespace . '\\' . 'PostCollection'
        );

        $query = new ModelQueryFactoryPrinter(
            $namespace,
            'PostQueryFactory',
            $namespace . '\\' . 'PostQuery',
            'post'
        );

        $model = new ModelConverterPrinter(
            $namespace,
            'PostConverter',
            'Leonidas\Library\System\Model\Post\Post',
            'Leonidas\Contracts\System\Model\Post\PostInterface',
            'user'
        );

        $this->printPhp($collection = $collection->printFile());
        file_put_contents($playground . '/factory-collection.php', $collection);

        $this->printPhp($query = $query->printFile());
        file_put_contents($playground . '/factory-query.php', $query);

        $this->printPhp($model = $model->printFile());
        file_put_contents($playground . '/factory-model.php', $model);
    }

    protected function testModel(string $playground): void
    {
        $interface = new ModelInterfacePrinter(
            $contracts = 'Leonidas\Contracts\System\Model\Post',
            $type = 'PostInterface',
            $template = 'attachment'
        );

        $class = new ModelPrinter(
            'Leonidas\Library\System\Model\Post',
            'Post',
            $contracts . '\\' . $type,
            'test',
            $template
        );

        $this->printPhp($interface = $interface->printFile());
        file_put_contents($playground . '/model-interface.php', $interface);

        $this->printPhp($class = $class->printFromType());
        file_put_contents($playground . '/model-class.php', $class);
    }

    protected function testRepository(string $playground): void
    {
        $interface = new ModelRepositoryInterfacePrinter(
            $model = PostInterface::class,
            $collection = PostCollectionInterface::class,
            $single = 'post',
            $plural = 'posts',
            $contracts = 'Leonidas\Contracts\System\Model\Post',
            $type = 'PostRepositoryInterface',
            $template = 'post'
        );

        $class = new ModelRepositoryPrinter(
            $model,
            $collection,
            $single,
            $plural,
            'Leonidas\Library\System\Model\Post',
            'PostRepository',
            $contracts . '\\' . $type,
            $template
        );

        $this->printPhp($interface = $interface->printFile());
        file_put_contents($playground . '/repository-interface.php', $interface);

        $this->printPhp($class = $class->printFile());
        file_put_contents($playground . '/repository-class.php', $class);
    }

    protected function testCollection(string $playground): void
    {
        $factory = ModelCollectionsFactory::build([
            'model' => PostInterface::class,
            'single' => 'post',
            'plural' => 'posts',
            'namespace' => 'Leonidas\Library\System\Model\Post',
            'contracts' => 'Leonidas\Contracts\System\Model\Post',
            'abstracts' => 'Leonidas\Library\System\Model\Post\Abstracts',
            'type' => 'PostCollectionInterface',
            'abstract' => 'AbstractPostCollection',
            'collection' => 'PostCollection',
            'query' => 'PostQuery',
            'entity' => 'post',
            'template' => 'post',
        ]);

        $output = [
            'interface' => $factory->getModelInterfacePrinter()->printFile(),
            'abstract' => $factory->getAbstractCollectionPrinter()->printFile(),
            'collection' => $factory->getChildCollectionPrinter()->printFile(),
            'query' => $factory->getChildQueryPrinter()->printFile(),
        ];

        foreach ($output as $class => $code) {
            $file = $playground . '/collection-' . $class . '.php';

            $this->printPhp($code);
            file_put_contents($file, $code);
        }
    }
}
