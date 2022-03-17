<?php

namespace Leonidas\Library\System\Model\Taxonomy;

use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyOptionHandlerInterface;

class TaxonomyOptionHandlerCollection implements TaxonomyOptionHandlerCollectionInterface
{
    /**
     * @return TaxonomyOptionHandlerInterface[]
     */
    protected array $handlers;

    public function __construct(array $handlers = [])
    {
        $this->with($handlers);
    }

    public function add(string $option, TaxonomyOptionHandlerInterface $handler)
    {
        $this->handlers[$option] = $handler;
    }

    public function with(array $handlers)
    {
        foreach ($handlers as $option => $handler) {
            $this->add($option, $handler);
        }
    }

    public function get(string $handler): TaxonomyOptionHandlerInterface
    {
        return $this->handlers[$handler];
    }

    public function remove(string $handler)
    {
        unset($this->handlers[$handler]);
    }

    public function has(string $handler): bool
    {
        return isset($this->handlers[$handler]);
    }

    public function all(): array
    {
        return $this->handlers;
    }

    public static function from(array $handlers): TaxonomyOptionHandlerCollection
    {
        return new static($handlers);
    }
}
