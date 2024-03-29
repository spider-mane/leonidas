<?php

namespace Leonidas\Library\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

class ComponentCallback
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function renderComponent(ServerRequestInterface $request): string
    {
        return ($this->getCallback())($request);
    }

    /**
     * Get the value of callback
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }
}
