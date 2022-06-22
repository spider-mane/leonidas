<?php

namespace Leonidas\Console\Library\Abstracts;

use ReflectionClass;

trait TypedClassPrinterTrait
{
    protected string $type;

    protected bool $isDoingTypeMatch = false;

    public function printFromType(): string
    {
        $this->isDoingTypeMatch = true;

        $output = $this->print($this->getSignaturesFromType());

        $this->isDoingTypeMatch = false;

        return $output;
    }

    protected function getSignaturesFromType(): array
    {
        $reflection = new ReflectionClass($this->type);
        $methods = $reflection->getMethods();
        $templates = $this->getDefaultSignatures();

        $signatures = [];

        foreach ($methods as $method) {
            if ($templates[$method = $method->getName()] ?? false) {
                $signatures[$method] = $templates[$method];
            }
        }

        return $signatures;
    }

    protected function isDoingTypeMatch(): bool
    {
        return $this->isDoingTypeMatch;
    }

    abstract protected function print(array $methods): string;

    abstract protected function getDefaultSignatures(): array;
}
