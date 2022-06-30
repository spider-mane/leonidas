<?php

namespace Leonidas\Console\Library\Printer\Model\Abstracts;

use Nette\PhpGenerator\PhpNamespace;

abstract class AbstractCompleteModelCollectionPrinter extends AbstractModelCollectionPrinter
{
    use TypedClassPrinterTrait;

    protected const TEMPLATES = [
        'getBy*' => [
            'give' => '?@model',
            'call' => 'firstWhere',
            'pass' => '#*, \'=\', $*',
        ],
        'hasWhere*Not' => [
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '#*, \'!=\', $*',
        ],
        'hasWhere*' => [
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '#*, \'=\', $*',
        ],
        'where*Not' => [
            'give' => '@self',
            'call' => 'where',
            'pass' => '#*, \'!=\', $*',
        ],
        'where*' => [
            'give' => '@self',
            'call' => 'where',
            'pass' => '#*, \'=\', $*',
        ],
        'hasWithout*' => [
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '#*, \'not in\', $*',
        ],
        'hasWith*' => [
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '#*, \'in\', $*',
        ],
        'without*' => [
            'give' => '@self',
            'call' => 'where',
            'pass' => '#*, \'not in\', $*',
        ],
        'with*' => [
            'give' => '@self',
            'call' => 'where',
            'pass' => '#*, \'in\', $*',
        ],
        'sortMappedBy*' => [
            'give' => '@self',
            'call' => 'sortMapped',
            'pass' => '$map, #*, $order',
        ],
    ];

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

    protected function getMethodTemplates(): array
    {
        return static::TEMPLATES;
    }

    protected function getParameterTypeReplacements(): array
    {
        return [
            ['@model', '@type'],
            [$this->model, $this->type],
        ];
    }
}
