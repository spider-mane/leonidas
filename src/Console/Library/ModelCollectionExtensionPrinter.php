<?php

namespace Leonidas\Console\Library;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\PoweredByModelQueryKernelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Nette\PhpGenerator\PhpNamespace;
use WP_Query;

class ModelCollectionExtensionPrinter extends AbstractClassPrinter
{
    public const CORE = 'kernel';

    protected string $model;

    protected string $single;

    protected string $plural;

    protected string $type;

    protected string $extends;

    protected string $entity;

    public function __construct(
        string $extends,
        string $model,
        string $single,
        string $plural,
        string $namespace,
        string $class,
        string $type,
        string $entity
    ) {
        parent::__construct($namespace, $class);

        $this->extends = $extends;
        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
        $this->type = $type;
        $this->entity = $entity;
    }

    public function printCollection(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
            $util = PoweredByModelCollectionKernelTrait::class;

            $this->buildDefaultNamespace($namespace)
                ->addUse($this->extends)
                ->addUse($this->model)
                ->addUse($util);

            $class = $namespace->addClass($this->class)
                ->setExtends($this->extends)
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

    public function printPostQuery(): string
    {
        return $this->print(function (PhpNamespace $namespace) {
            $engine = PoweredByModelQueryKernelTrait::class;
            $validator = ValidatesPostTypeTrait::class;
            $converter = PostConverterInterface::class;
            $query = WP_Query::class;

            $this->buildDefaultNamespace($namespace)
                ->addUse($this->extends)
                ->addUse($validator)
                ->addUse($engine)
                ->addUse($converter)
                ->addUse($query);

            $class = $namespace->addClass($this->class)
                ->setExtends($this->extends)
                ->addImplement($this->type);

            $class->addTrait($engine);
            $class->addTrait($validator);

            $constructor = $class->addMethod('__construct');

            $constructor->addParameter('query')->setType($query);
            $constructor->addParameter('converter')->setType($converter);
            $constructor->addBody(
                '$this->assertPostTypeOnQuery($query, ?);',
                [$this->entity]
            );
            $constructor->addBody('$this->initKernel($query, $converter);');

            return $class;
        });
    }

    protected function buildDefaultNamespace(PhpNamespace $namespace): PhpNamespace
    {
        return $namespace->addUse($this->type);
    }
}
