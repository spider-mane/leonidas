<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;

class AbstractInlineAsset
{
    protected string $handle;

    protected string $data;

    protected ?ConstrainerCollectionInterface $constraints = null;

    public function __construct(string $handle, string $data, ConstrainerCollectionInterface $constraints)
    {
        $this->handle = $handle;
        $this->data = $data;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return !$this->constraints->constrains($request);
    }
}
