<?php

namespace Leonidas\Library\System\PostType;

use Leonidas\Contracts\System\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\PostType\PostTypeOptionHandlerInterface;

class PostTypeOptionHandlerCollection implements PostTypeOptionHandlerCollectionInterface
{
    /**
     * @return PostTypeOptionHandlerInterface[]
     */
    protected array $handlers;

    public function __construct(array $handlers = [])
    {
        $this->with($handlers);
    }

    public function add(string $option, PostTypeOptionHandlerInterface $handler)
    {
        $this->handlers[$option] = $handler;
    }

    public function with(array $handlers)
    {
        foreach ($handlers as $option => $handler) {
            $this->add($option, $handler);
        }
    }

    public function get(string $handler): PostTypeOptionHandlerInterface
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

    public static function from(array $handlers): PostTypeOptionHandlerCollection
    {
        return new static($handlers);
    }
}
