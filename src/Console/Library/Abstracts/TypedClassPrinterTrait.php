<?php

namespace Leonidas\Console\Library\Abstracts;

use ReflectionClass;

trait TypedClassPrinterTrait
{
    protected string $type;

    public function printFromType(): string
    {
        return $this->print($this->getSignaturesFromType());
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

    abstract protected function print(array $methods): string;

    abstract protected function getNativeSignatures(): array;
}
