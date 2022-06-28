<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractClassPrinter;
use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionFactoryPrinter extends AbstractClassPrinter
{
    protected string $collection;

    public function __construct(string $namespace, string $class, string $collection)
    {
        parent::__construct($namespace, $class);
        $this->collection = $collection;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = EntityCollectionFactoryInterface::class;
        $return = explode('\\', $this->collection);
        $return = end($return);

        $class = $namespace->addUse($base)->addClass($this->class);

        $class->addImplement($base);
        $class->addMethod('createEntityCollection')
            ->setVariadic(true)
            ->setReturnType($this->collection)
            ->setBody(sprintf('return new %s(...$entities);', $return))
            ->addParameter('entities')
            ->setType('object');

        return $class;
    }
}
