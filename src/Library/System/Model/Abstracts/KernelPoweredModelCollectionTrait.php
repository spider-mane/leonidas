<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Library\Abstracts\KernelPoweredCollectionTrait;

trait KernelPoweredModelCollectionTrait
{
    use KernelPoweredCollectionTrait;

    public function map(callable $callback): array
    {
        return $this->kernel->map($callback);
    }

    public function walk(callable $callback): void
    {
        $this->kernel->walk($callback);
    }

    public function foreach(callable $callback): void
    {
        $this->kernel->foreach($callback);
    }

    public function extract(string $property): array
    {
        return $this->kernel->column($property);
    }
}
