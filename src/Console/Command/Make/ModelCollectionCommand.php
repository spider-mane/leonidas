<?php

namespace Leonidas\Console\Command\Make;

use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelCollectionsFactory;
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
        $this->testCollection();
        $this->testRepository();

        return 0;
    }

    protected function testRepository(): void
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
        $this->printPhp($class = $class->printFile());

        $location = getcwd() . '/.playground/factory';

        file_put_contents($location . '/repository-interface.php', $interface);
        file_put_contents($location . '/repository-class.php', $class);
    }

    protected function testCollection(): void
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
            $file = getcwd() . '/.playground/factory/collection-' . $class . '.php';

            $this->printPhp($code);

            file_put_contents($file, $code);
        }
    }
}
