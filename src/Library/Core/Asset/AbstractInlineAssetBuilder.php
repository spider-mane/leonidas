<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

abstract class AbstractInlineAssetBuilder
{
    protected string $handle;

    protected string $data;

    protected ConstrainerCollectionInterface $constraints;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    public function handle(string $handle): AbstractInlineAssetBuilder
    {
        return $this->handle = $handle;

        return $this;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function data(string $data): AbstractInlineAssetBuilder
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function constraints(ConstrainerCollectionInterface $constraints): AbstractInlineAssetBuilder
    {
        $this->constraints = $constraints;

        return $this;
    }

    public function getConstraints(): ConstrainerCollectionInterface
    {
        return $this->constraints;
    }
}
