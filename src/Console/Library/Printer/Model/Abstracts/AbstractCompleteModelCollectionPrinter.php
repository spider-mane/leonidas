<?php

namespace Leonidas\Console\Library\Printer\Model\Abstracts;

use Nette\PhpGenerator\PhpNamespace;

abstract class AbstractCompleteModelCollectionPrinter extends AbstractModelCollectionPrinter
{
    use TypedClassPrinterTrait;

    public function __construct(
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type
    ) {
        parent::__construct($model, $single, $plural, $namespace, $class);

        $this->type = $type;
    }

    protected function buildDefaultNamespace(PhpNamespace $namespace): PhpNamespace
    {
        return $namespace->addUse($this->type)->addUse($this->model);
    }

    protected function getParameterTypeReplacements(): array
    {
        return [
            ['@model', '@type'],
            [$this->model, $this->type],
        ];
    }
}
