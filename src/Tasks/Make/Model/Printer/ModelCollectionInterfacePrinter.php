<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;
use Leonidas\Tasks\Make\Model\Printer\Abstracts\AbstractModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionInterfacePrinter extends AbstractModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = ModelCollectionInterface::class;

        $interface = $namespace
            ->addUse($this->model)
            ->addUse($base)
            ->addInterface($this->class);

        $interface->addExtend($base);

        return $interface;
    }
}
