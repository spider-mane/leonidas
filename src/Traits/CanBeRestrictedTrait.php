<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;

trait CanBeRestrictedTrait
{
    protected ?ConstrainerCollectionInterface $constraints = null;

    public function getConstraints(): ?ConstrainerCollectionInterface
    {
        return $this->constraints;
    }

    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return !isset($this->constraints) || !$this->constraints->constrains($request);
    }
}
