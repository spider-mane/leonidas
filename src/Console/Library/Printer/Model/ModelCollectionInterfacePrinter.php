<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractModelCollectionPrinter;
use Leonidas\Contracts\System\Model\ModelCollectionInterface;
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
