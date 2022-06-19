<?php

namespace Leonidas\Console\Command\Make;

use Leonidas\Console\Command\HopliteCommand;
use Leonidas\Console\Library\ModelCollectionExtensionPrinter;
use Leonidas\Console\Library\ModelCollectionPrinter;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Post\Abstracts\AbstractPostCollection;
use Leonidas\Library\System\Model\Post\PostCollection;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $collection = explode('\\', PostCollection::class);
        $class = array_pop($collection);
        $namespace = implode('\\', $collection);

        $model = PostInterface::class;
        $single = 'post';
        $plural = 'posts';
        $implements = PostCollectionInterface::class;

        $printer = new ModelCollectionPrinter(
            $model,
            $single,
            $plural,
            $namespace,
            $class,
            $implements
        );

        $file = $printer->printCollection();
        $this->printPhp($file);

        $file = $printer->printCollectionTrait();
        $this->printPhp($file);

        $file = $printer->printAbstractCollection();
        $this->printPhp($file);

        $file = $printer->printCollectionInterface();
        $this->printPhp($file);

        $printer = new ModelCollectionExtensionPrinter(
            AbstractPostCollection::class,
            $model,
            $single,
            $plural,
            $namespace,
            $class,
            $implements,
            'post'
        );

        $file = $printer->printPostQuery();
        $this->printPhp($file);

        $file = $printer->printCollection();
        $this->printPhp($file);

        // exit;

        file_put_contents(
            '.playground/' . $class . '.php',
            $file
        );

        exit;
    }
}
