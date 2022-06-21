<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionInterfacePrinter extends AbstractModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace)
    {
        return $namespace->addUse($this->model)->addInterface($this->class);
    }
}
