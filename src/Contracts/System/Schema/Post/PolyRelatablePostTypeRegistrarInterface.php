<?php

namespace Leonidas\Contracts\System\Schema\Post;

interface PolyRelatablePostTypeRegistrarInterface
{
    public function register(PolyRelatablePostTypeInterface $relatable): void;

    public function update(string $relatable, string $related): void;
}
