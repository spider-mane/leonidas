<?php

namespace Leonidas\Console\Library;

use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Nette\PhpGenerator\PhpNamespace;

class ModelCollectionPrinter extends AbstractClassPrinter
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
            'pass' => '@single',
            'take' => '@model @single',
            'call' => 'insert',
        ],
        'collect' => [
            'pass' => '@plural',
            'take' => '@model ...@plural',
        ],
        'remove' => [
            'take' => 'int $id',
            'pass' => '$id',
        ],
        'merge' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'diff' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'contrast' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'intersect' => [
            'take' => '@type ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
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

    protected string $type;

    public function __construct(
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type
    ) {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
        $this->type = $type;
    }

    public function printCollection(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
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
            $constructor->setBody(sprintf('$this->initKernel($%s);', $this->plural));

            return $class;
        });
    }

    public function printAbstractCollection(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
            $base = AbstractModelCollection::class;

            $this->buildDefaultNamespace($namespace)->addUse($base);

            $class = $namespace->addClass($this->class)
                ->setAbstract(true)
                ->setExtends($base)
                ->addImplement($this->type);

            return $class;
        });
    }

    public function printCollectionTrait(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
            return $this->buildDefaultNamespace($namespace)
                ->addTrait($this->class);
        });
    }

    public function printCollectionInterface(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
            return $this->buildDefaultNamespace($namespace)
                ->addInterface($this->class);
        });
    }

    protected function buildDefaultNamespace(PhpNamespace $namespace): PhpNamespace
    {
        return $namespace->addUse($this->type)->addUse($this->model);
    }

    protected function getMethodPassReplacements(): array
    {
        return [
            ['@single', '@plural'],
            ['$' . $this->single, '$' . $this->plural],
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
            [$this->model, $this->type],
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
