<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface PolyRelatablePostTypeRepositoryInterface
{
    public function get(string $postType): PolyRelatablePostTypeInterface;

    public function getByShadow(string $shadow): PolyRelatablePostTypeInterface;

    public function has(string $postType): bool;

    public function hasByShadow(string $shadow): bool;

    public function add(PolyRelatablePostTypeInterface $relatable): void;
}
