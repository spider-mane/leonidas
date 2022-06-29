<?php

namespace Leonidas\Console\Library\Printer\Model\Abstracts;

abstract class AbstractModelCollectionPrinter extends AbstractClassPrinter
{
    public const CORE = 'kernel';

    public const SIGNATURES = [
        'collect' => [
            'take' => '@model ...@plural',
            'pass' => '$@plural',
        ],
        'add' => [
            'take' => '@model @single',
            'call' => 'insert',
            'pass' => '$@single',
        ],
        'hasWithId' => [
            'take' => 'int ...$id',
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '\'id\', \'in\', $id',
        ],
        'hasWith' => [
            'take' => 'string $property, ...$values',
            'give' => 'bool',
            'call' => 'hasWhere',
            'pass' => '$property, \'in\', $values',
        ],
        'hasWhere' => [
            'take' => 'string $property, string $operator, $value',
            'give' => 'bool',
            'pass' => '$property, $operator, $value',
        ],
        'matches' => [
            'take' => '@type @plural',
            'give' => 'bool',
            'pass' => '$@plural->toArray()',
        ],
        'getById' => [
            'take' => 'int $id',
            'give' => '?@model',
            'call' => 'firstWhere',
            'pass' => '\'id\', \'=\', $id',
        ],
        'getBy' => [
            'take' => 'string $property, $value',
            'give' => '?@model',
            'call' => 'firstWhere',
            'pass' => '$property, \'=\', $value',
        ],
        'firstWhere' => [
            'take' => 'string $property, string $operator, $value',
            'give' => '?@model',
            'pass' => '$property, $operator, $value',
        ],
        'first' => [
            'give' => '?@model',
        ],
        'last' => [
            'give' => '?@model',
        ],
        'withId' => [
            'take' => 'int ...$id',
            'give' => '@self',
            'call' => 'where',
            'pass' => '\'id\', \'in\', $id',
        ],
        'withoutId' => [
            'take' => 'int ...$id',
            'give' => '@self',
            'call' => 'where',
            'pass' => '\'id\', \'not in\', $id',
        ],
        'with' => [
            'take' => 'string $property, ...$values',
            'give' => '@self',
            'call' => 'where',
            'pass' => '$property, \'in\', $values',
        ],
        'without' => [
            'take' => 'string $property, ...$values',
            'give' => '@self',
            'call' => 'where',
            'pass' => '$property, \'not in\', $values',
        ],
        'where' => [
            'take' => 'string $property, string $operator, $value',
            'give' => '@self',
            'pass' => '$property, $operator, $value',
        ],
        'filter' => [
            'take' => 'callable $callback',
            'give' => '@self',
            'pass' => '$callback',
        ],
        'diff' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...$@plural)',
        ],
        'contrast' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...$@plural)',
        ],
        'intersect' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...$@plural)',
        ],
        'merge' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...$@plural)',
        ],
        'sortBy' => [
            'take' => 'string $property, string $order = \'asc\'',
            'give' => '@self',
            'pass' => '$property, $order',
        ],
        'sortMapped' => [
            'take' => 'array $map, string $property, string $order = \'asc\'',
            'give' => '@self',
            'pass' => '$map, $property, $order',
        ],
        'sortCustom' => [
            'take' => 'callable $callback, string $order = \'asc\'',
            'give' => '@self',
            'pass' => '$callback, $order',
        ],
    ];

    protected string $model;

    protected string $single;

    protected string $plural;

    public function __construct(
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class
    ) {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
    }

    protected function getMethodPassReplacements(): array
    {
        return [
            ['@single', '@plural'],
            [$this->single, $this->plural],
        ];
    }

    protected function getMethodGiveReplacements(): array
    {
        return [
            ['@model', '@self'],
            [$this->model, $this->getClassFqn()],
        ];
    }

    protected function getParameterTypeReplacements(): array
    {
        return [
            ['@model', '@type'],
            [$this->model, $this->getClassFqn()],
        ];
    }

    protected function getParameterNameReplacements(): array
    {
        return [
            ['@single', '@plural'],
            [$this->single, $this->plural],
        ];
    }
}
