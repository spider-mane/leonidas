<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractCompleteModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionTraitPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
    {
        return $this->buildDefaultNamespace($namespace)->addTrait($this->class);
    }
}
