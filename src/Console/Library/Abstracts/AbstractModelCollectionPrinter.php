<?php

namespace Leonidas\Console\Library\Abstracts;

abstract class AbstractModelCollectionPrinter extends AbstractClassPrinter
{
    public const CORE = 'kernel';

    public const SIGNATURES = [
        'get' => [
            'take' => 'int $id',
            'give' => '@model',
            'call' => 'fetch',
            'pass' => '$id',
        ],
        'first' => [
            'give' => '@model',
        ],
        'last' => [
            'give' => '@model',
        ],
        'add' => [
            'take' => '@model @single',
            'call' => 'insert',
            'pass' => '$@single',
        ],
        'collect' => [
            'take' => '@model ...@plural',
            'pass' => '$@plural',
        ],
        'remove' => [
            'take' => 'int $id',
            'pass' => '$id',
        ],
        'merge' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...$@plural)',
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
        'filter' => [
            'take' => 'callable $callback',
            'give' => '@self',
            'pass' => '$callback',
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
