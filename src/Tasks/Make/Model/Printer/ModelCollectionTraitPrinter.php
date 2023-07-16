<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Tasks\Make\Model\Printer\Abstracts\AbstractCompleteModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionTraitPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
    {
        return $this->buildDefaultNamespace($namespace)->addTrait($this->class);
    }
}
