<?php

namespace Leonidas\Console\Command\Make;

use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelCollectionsFactory;
use Leonidas\Console\Library\ModelInterfacePrinter;
use Leonidas\Console\Library\ModelPrinter;
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
        $playground = getcwd() . '/.playground/factory';

        $this->testCollection($playground);
        $this->testRepository($playground);
        $this->testModel($playground);
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
