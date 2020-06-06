<?php

namespace WebTheory\Leonidas\Traits;

use WebTheory\Leonidas\Priorities;

trait HooksInTrait
{
    /**
     * @var Priorities
     */
    protected $priorities;

    /**
     *
     */
    public function setPriorities(Priorities $priorities)
    {
        $this->priorities = $priorities;
    }

    /**
     *
     */
    protected function defineCallbackPriority(string $tag): ?int
    {
        return $this->priorities ? $this->priorities->getPriority($tag) : null;
    }

    /**
     *
     */
    protected function addAction(string $tag, callable $callback, int $args = PHP_INT_MAX)
    {
        add_action($tag, $callback, $this->defineCallbackPriority($tag), $args);

        return $this;
    }

    /**
     *
     */
    protected function addFilter(string $tag, callable $callback, int $args = PHP_INT_MAX)
    {
        add_filter($tag, $callback, $this->defineCallbackPriority($tag), $args);

        return $this;
    }
}
