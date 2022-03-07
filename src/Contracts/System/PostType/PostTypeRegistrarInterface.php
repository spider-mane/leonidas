<?php

namespace Leonidas\Contracts\System\PostType;

interface PostTypeRegistrarInterface
{
    public function registerOne(PostTypeInterface $postType);

    public function registerMany(PostTypeInterface ...$postTypes);
}
