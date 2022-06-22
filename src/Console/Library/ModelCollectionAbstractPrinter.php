<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractCompleteModelCollectionPrinter;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionAbstractPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = AbstractModelCollection::class;

        $this->buildDefaultNamespace($namespace)->addUse($base);

        $class = $namespace->addClass($this->class)
            ->setAbstract(true)
            ->setExtends($base)
            ->addImplement($this->type);

        return $class;
    }
}
