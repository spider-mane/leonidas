<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Core\Http\ConstrainerCollection;
use Psr\Http\Message\ServerRequestInterface;

class AbstractInlineAsset
{
    protected string $handle;

    protected string $code;

    protected ?ConstrainerCollectionInterface $constraints = null;

    public function __construct(string $handle, string $code, ?ConstrainerCollectionInterface $constraints = null)
    {
        $this->handle = $handle;
        $this->code = $code;

        $this->constraints = $constraints ?? new ConstrainerCollection();
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getConstraints(): ConstrainerCollectionInterface
    {
        return $this->constraints;
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return !$this->constraints->constrains($request);
    }
}
