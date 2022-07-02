<?php

namespace Leonidas\Console\Library\Printer\Model;

use Leonidas\Console\Library\Printer\Model\Abstracts\AbstractTypedClassPrinter;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use ReflectionMethod;

class ModelRepositoryFacadePrinter extends AbstractTypedClassPrinter
{
    protected string $template;

    protected string $queryFactory;

    protected string $query;

    public function __construct(
        string $class,
        string $namespace,
        string $iRepository,
        string $queryFactory,
        string $query,
        string $template
    ) {
        parent::__construct($namespace, $class, $iRepository);

        $this->queryFactory = $queryFactory;
        $this->query = $query;
        $this->template = $template;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $namespace->addUse($this->type);

        $class = $namespace->addClass($this->class)
            ->setExtends($this->namespace . '\\' . '_Facade');

        if ($this->isDoingTypeMatch()) {
            $this->addMethodAnnotations($class);
        }

        if ($this->isPostTemplate()) {
            $namespace->addUse($this->queryFactory)->addUse($this->query);

            $class->addMethod('fromQuery')
                ->setPublic()
                ->setStatic(true)
                ->setReturnType($this->query)
                ->setBody(
                    'return static::getQueryFactory()->createQuery($GLOBALS[\'wp_query\']);'
                );

            $class->addMethod('getQueryFactory')
                ->setProtected()
                ->setStatic(true)
                ->setReturnType($this->queryFactory)
                ->setBody(sprintf(
                    'return static::$container->get(%s::class);',
                    $this->getClassFromFqn($this->queryFactory)
                ));
        }

        $class->addMethod('_getFacadeAccessor')
            ->setProtected()
            ->setStatic(true)
            ->setReturnType('string')
            ->setBody('return ' . $this->getClassFromFqn($this->type) . '::class;');

        return $class;
    }

    protected function addMethodAnnotations(ClassType $class): void
    {
        foreach ((array) get_class_methods($this->type) as $method) {
            $reflection = new ReflectionMethod($this->type, $method);
            $returnReflection = $reflection->getReturnType();
            $returnType = $returnReflection->getName(); // @phpstan-ignore-line

            if ($this->typeIsConstruct($returnType)) {
                $this->addImport($returnType);
            }

            $class->addComment(sprintf(
                '@method static %s%s %s(%s)',
                $returnReflection->allowsNull() ? '?' : '',
                $this->getClassFromFqn($returnType),
                $method,
                $this->stringifyParams($reflection)
            ));
        }
    }

    public function isPostTemplate(): bool
    {
        return in_array($this->template, ['post', 'post:h', 'attachment']);
    }
}
