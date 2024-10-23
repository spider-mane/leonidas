<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

interface PostTypeRegistrarInterface
{
    public function registerOne(PostTypeInterface $postType);

    public function registerMany(PostTypeInterface ...$postTypes);

    public function overrideOne(PostTypeInterface $postType);

    public function overrideMany(PostTypeInterface ...$postTypes);
}
