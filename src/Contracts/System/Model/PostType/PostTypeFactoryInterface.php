<?php

namespace Leonidas\Contracts\System\Model\PostType;

interface PostTypeFactoryInterface
{
    public function create(string $name, array $args): PostTypeInterface;

    public function build(string $name, array $args): PostTypeBuilderInterface;

    /**
     * @return PostTypeInterface[]
     */
    public function createMany(array $definitions): array;

    /**
     * @return PostTypeBuilderInterface[]
     */
    public function buildMany(array $definitions): array;
}
