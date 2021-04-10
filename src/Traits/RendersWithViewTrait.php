<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Ui\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;

trait RendersWithViewTrait
{
    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->defineView($request)->render($this->defineViewContext($request));
    }

    /**
     *
     */
    abstract protected function defineView(ServerRequestInterface $request): ViewInterface;

    /**
     *
     */
    abstract protected function defineViewContext(ServerRequestInterface $request): array;
}
