<?php

namespace WebTheory\Leonidas;

class Priorities
{
    /**
     * @var  array
     */
    protected $priorities = [];

    /**
     *
     */
    protected function __construct(array $priorities)
    {
        foreach ($priorities as $hook => $priority) {
            $this->setPriority($hook, $priority);
        }
    }

    /**
     *
     */
    public function setPriority(string $hook, ?int $priority)
    {
        $this->priorities[$hook] = $priority;

        return $this;
    }

    /**
     *
     */
    public function getPriority(string $hook): ?int
    {
        return $this->priorities[$hook] ?? null;
    }
}
