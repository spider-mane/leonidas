<?php

namespace WebTheory\Leonidas\Library\Core\Hook;

use WebTheory\Leonidas\Contracts\Hook\HookInterface;

class Hook implements HookInterface
{
    /**
     * @var string
     */
    protected $tag;

    /**
     * @var array
     */
    protected $args;

    /**
     *
     */
    public function __construct(string $tag, array $args)
    {
        $this->tag = $tag;
        $this->args = $args;
    }

    /**
     * Get the value of tag
     *
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Get the value of args
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}
