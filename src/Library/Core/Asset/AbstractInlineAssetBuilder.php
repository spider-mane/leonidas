<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;

abstract class AbstractInlineAssetBuilder
{
    protected string $handle;

    protected string $code;

    protected ?ServerRequestPolicyInterface $policy = null;

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

    public function code(string $code): AbstractInlineAssetBuilder
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function policy(?ServerRequestPolicyInterface $policy): AbstractInlineAssetBuilder
    {
        $this->policy = $policy;

        return $this;
    }

    public function getPolicy(): ?ServerRequestPolicyInterface
    {
        return $this->policy;
    }
}
