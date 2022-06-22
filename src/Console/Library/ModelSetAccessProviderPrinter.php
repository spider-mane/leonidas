<?php

namespace Leonidas\Console\Library;

use Leonidas\Console\Library\Abstracts\AbstractClassPrinter;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\DatableAccessProviderTrait;
use Leonidas\Library\System\Model\SetAccessProvider;
use Nette\PhpGenerator\PhpNamespace;

class ModelSetAccessProviderPrinter extends AbstractClassPrinter
{
    protected string $model;

    protected string $single;

    protected bool $isDatable;

    public function __construct(string $namespace, string $class, string $model, string $single, bool $isDatable = true)
    {
        parent::__construct($namespace, $class);

        $this->model = $model;
        $this->single = $single;
        $this->isDatable = $isDatable;
    }

    protected function setupClass(PhpNamespace $namespace): object
    {
        $base = SetAccessProvider::class;
        $contract = SetAccessProviderInterface::class;
        $datableTrait = DatableAccessProviderTrait::class;

        $class = $namespace
            ->addUse($base)
            ->addUse($contract)
            ->addUse($this->model)
            ->addClass($this->class);

        $class->addImplement($contract);
        $class->setExtends($base);

        if ($this->isDatable) {
            $namespace->addUse($datableTrait);
            $class->addTrait($datableTrait);
        }

        $class->addMethod('__construct')
            ->setPublic()
            ->setBody(sprintf(
                'parent::__construct($%s, $this->resolvedSetters($%s));',
                $this->single,
                $this->single
            ))
            ->addParameter($this->single)
            ->setType($this->model);

        $class->addMethod('resolvedSetters')
            ->setPublic()
            ->setReturnType('array')
            ->setBody($this->getResolvedSettersMethodBody())
            ->addParameter($this->single)
            ->setType($this->model);

        return $class;
    }

    protected function getResolvedSettersMethodBody(): string
    {
        $base = 'return [];';
        $datable = trim($base, ';') . ' + $this->resolvedDatableSetters($%s);';

        return $this->isDatable ? sprintf($datable, $this->single) : $base;
    }
}
