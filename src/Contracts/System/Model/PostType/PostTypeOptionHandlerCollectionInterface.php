<?php

namespace Leonidas\Contracts\System\Model\PostType;

interface PostTypeOptionHandlerCollectionInterface
{
    public function add(string $option, PostTypeOptionHandlerInterface $handler);

    public function with(array $handlers);

    public function get(string $handler): PostTypeOptionHandlerInterface;

    public function remove(string $handler);

    public function has(string $handler): bool;

    /**
     * @return PostTypeOptionHandlerInterface[]
     */
    public function all(): array;
}
