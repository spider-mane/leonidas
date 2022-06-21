<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractCompleteModelCollectionPrinter;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace)
    {
        $base = AbstractModelCollection::class;
        $util = PoweredByModelCollectionKernelTrait::class;

        $this->buildDefaultNamespace($namespace)
            ->addUse($base)
            ->addUse($util);

        $class = $namespace->addClass($this->class)
            ->setExtends($base)
            ->addImplement($this->type);

        $class->addTrait($util);
        $class->addConstant('MODEL_IDENTIFIER', 'id')->setProtected();
        $class->addConstant('COLLECTION_IS_MAP', true)->setProtected();

        $constructor = $class->addMethod('__construct')->setVariadic(true);

        $constructor->addParameter($this->plural)->setType($this->model);
        $constructor->setBody(
            sprintf('$this->initKernel($%s);', $this->plural)
        );

        return $class;
    }
}
