<?php

namespace WebTheory\GuctilityBelt;

class ContextView
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $contexts;

    /**
     *
     */
    public function __construct(array $items, array $contexts)
    {
        $this->items = $items;
        $this->contexts = $contexts;
    }

    /**
     *
     */
    public function getContext(string $context)
    {
        return $this->contexts[$context];
    }

    /**
     *
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     *
     */
    public function getItem(string $item)
    {
        return $this->items[$item];
    }

    /**
     *
     */
    public function getItems(string ...$items)
    {
        if ($items) {
            $selection = [];

            foreach ($items as $platform) {
                $selection[$platform] = $this->items[$platform];
            }
        }

        return $selection ?? $this->items;
    }

    /**
     *
     */
    public function getContextItems(string $context)
    {
        return $this->getItems(...$this->contexts[$context]);
    }
}
