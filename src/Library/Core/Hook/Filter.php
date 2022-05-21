<?php

namespace Leonidas\Library\Core\Hook;

class Filter
{
    protected string $tag;

    protected string $id;

    /**
     * @var callable
     */
    protected $callback;

    protected int $priority = 10;

    protected int $acceptedArgs = 1;

    public const FILTER_PREFIX = 'listeners.filters';

    public function __construct(string $tag, string $id, callable $callback)
    {
        $this->tag = $tag;
        $this->id = $id;
        $this->callback = $callback;
    }

    /**
     * Set the value of priority
     *
     * @param int $priority
     *
     * @return self
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Set the value of argCount
     *
     * @param int $argCount
     *
     * @return self
     */
    public function setAcceptedArgs(int $argCount)
    {
        $this->acceptedArgs = $argCount;

        return $this;
    }

    protected function addListener()
    {
        add_filter($this->tag, [$this, 'maybeRunCallback'], $this->priority, $this->acceptedArgs);
    }

    public function maybeRunCallback(...$args)
    {
        if ($this->callbackShouldRun()) {
            return ($this->callback)(...$args);
        } else {
            return $args[0] ?? null;
        }
    }

    protected function callbackShouldRun(): bool
    {
        $prefix = static::FILTER_PREFIX;

        return apply_filters("{$prefix}.{$this->id}", true);
    }

    public static function add(
        string $tag,
        string $id,
        callable $callback,
        ?int $priority = null,
        ?int $acceptedArgs = null
    ) {
        $filter = new static($tag, $id, $callback);

        $priority && $filter->setPriority($priority);
        $acceptedArgs && $filter->setAcceptedArgs($acceptedArgs);

        $filter->addListener();

        return $filter;
    }

    public static function remove(string $id, int $priority = 10)
    {
        $prefix = static::FILTER_PREFIX;

        add_filter("{$prefix}.{$id}", '__return_false', 0, $priority);
    }
}
