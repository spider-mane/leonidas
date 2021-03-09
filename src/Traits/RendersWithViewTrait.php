<?php

namespace WebTheory\Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;

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
