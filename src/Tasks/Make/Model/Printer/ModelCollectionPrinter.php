<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Leonidas\Tasks\Make\Model\Printer\Abstracts\AbstractCompleteModelCollectionPrinter;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionPrinter extends AbstractCompleteModelCollectionPrinter
{
    protected function setupClass(PhpNamespace $namespace): object
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
        // $class->addConstant('MODEL_IDENTIFIER', 'id')->setProtected();
        // $class->addConstant('COLLECTION_IS_MAP', true)->setProtected();

        $constructor = $class->addMethod('__construct')->setVariadic(true);

        $constructor->addParameter($this->plural)->setType($this->model);
        $constructor->setBody(
            sprintf('$this->initKernel($%s);', $this->plural)
        );

        return $class;
    }
}
