<?php

namespace Leonidas\Console\Library\Abstracts;

abstract class AbstractModelRepositoryPrinter extends AbstractClassPrinter
{
    public const CORE = 'manager';

    public const SIGNATURES = [
        'select' => [
            'take' => 'int $id',
            'give' => '@model',
            'pass' => '$id',
        ],
        'whereIds' => [
            'take' => 'int ...$ids',
            'give' => '@collection',
            'pass' => '...$ids',
        ],
        'query' => [
            'take' => 'array $query',
            'give' => '@collection',
            'pass' => '$query',
        ],
        'all' => [
            'give' => '@collection',
        ],
        'make' => [
            'take' => 'array $data',
            'give' => '@model',
            'call' => 'spawn',
            'pass' => '$data',
        ],
        'insert' => [
            'take' => '@model @single',
            'pass' => '$this->extractData($@single)',
        ],
        'update' => [
            'take' => '@model @single',
            'pass' => '$@single->getId(), $this->extractData($@single)',
        ],
    ];

    protected string $model;

    protected string $collection;

    protected string $single;

    protected string $plural;

    protected string $template;

    public function __construct(
        string $model,
        string $collection,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $template
    ) {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->collection = $collection;
        $this->single = $single;
        $this->plural = $plural;
        $this->template = $template;
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
            ['@model', '@collection'],
            [$this->model, $this->collection],
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
            ['@single'],
            [$this->single],
        ];
    }
}
