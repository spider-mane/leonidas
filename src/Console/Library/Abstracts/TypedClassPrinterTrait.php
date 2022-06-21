<?php

namespace Leonidas\Console\Library\Abstracts;

use Leonidas\Console\Library\ClassType;
use Leonidas\Console\Library\InterfaceType;
use Leonidas\Console\Library\TraitType;
use Nette\PhpGenerator\PhpNamespace;
use ReflectionClass;

trait TypedClassPrinterTrait
{
    protected string $type;

    public function printFromType(): string
    {
        return $this->print(
            fn (PhpNamespace $namespace) => $this->addMethods(
                $this->setupClass($namespace),
                $this->getSignaturesFromType()
            )
        );
    }

    protected function getSignaturesFromType(): array
    {
        $reflection = new ReflectionClass($this->type);
        $methods = $reflection->getMethods();
        $templates = $this->getNativeSignatures();

        $signatures = [];

        foreach ($methods as $method) {
            if ($templates[$method = $method->name] ?? false) {
                $signatures[$method] = $templates[$method];
            }
        }

        return $signatures;
    }

    /**
     * @return ClassType|TraitType|InterfaceType
     */
    abstract protected function setupClass(PhpNamespace $namespace);

    abstract protected function getNativeSignatures(): array;
}
