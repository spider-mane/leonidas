<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractClassPrinter;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionAsChildPrinter extends AbstractClassPrinter
{
    public const CORE = 'kernel';

    protected string $model;

    protected string $single;

    protected string $plural;

    protected string $type;

    protected string $extends;

    public function __construct(
        string $extends,
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type
    ) {
        parent::__construct($namespace, $class);

        $this->extends = $extends;
        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
        $this->type = $type;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $util = PoweredByModelCollectionKernelTrait::class;

        $namespace
            ->addUse($this->type)
            ->addUse($this->extends)
            ->addUse($this->model)
            ->addUse($util);

        $class = $namespace->addClass($this->class)
            ->setExtends($this->extends)
            ->addImplement($this->type);

        $class->addTrait($util);
        // $class->addConstant('MODEL_IDENTIFIER', 'id')->setProtected();
        // $class->addConstant('COLLECTION_IS_MAP', true)->setProtected();

        $constructor = $class->addMethod('__construct')->setVariadic(true);

        $constructor->addParameter($this->plural)->setType($this->model);
        $constructor->setBody(sprintf('$this->initKernel($%s);', $this->plural));

        return $class;
    }
}
