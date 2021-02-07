<?php

namespace WebTheory\Leonidas;

abstract class AbstractWpObjectFactory
{
    /**
     * @var array
     */
    protected $optionHandlers;

    /**
     *
     */
    public function __construct(array $optionHandlers = null)
    {
        $this->optionHandlers = $optionHandlers;
    }

    /**
     *
     */
    public function create(array $objects): array
    {
        foreach ($objects as $name => $args) {
            $objects[$name] = $this->build($name, $args);
        }

        return $objects;
    }

    /**
     *
     */
    abstract public function build(string $name, array $args): object;
}
