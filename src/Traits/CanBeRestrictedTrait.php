<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;

trait CanBeRestrictedTrait
{
    protected ConstrainerCollectionInterface $constraints;

    public function getConstraints(): ConstrainerCollectionInterface
    {
        return $this->constraints;
    }

    public function setConstraints(ConstrainerCollectionInterface $constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }

    public function shouldBeRendered(ServerRequestInterface $request): bool
    {
        return !$this->constraints->constrains($request);
    }
}
