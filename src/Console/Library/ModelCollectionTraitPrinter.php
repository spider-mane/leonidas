<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractCompleteModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionTraitPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace)
    {
        return $this->buildDefaultNamespace($namespace)->addTrait($this->class);
    }
}
