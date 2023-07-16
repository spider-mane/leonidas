<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Tasks\Make\Abstracts\AbstractClassPrinter;
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
