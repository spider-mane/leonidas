<?php

namespace Leonidas\Contracts\System\Model\PostType;

interface PostTypeRegistrarInterface
{
    public function registerOne(PostTypeInterface $postType);

    public function registerMany(PostTypeInterface ...$postTypes);
}
