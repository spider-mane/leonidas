<?php

namespace Leonidas\Contracts\System\Model\Tag;

interface HasManyTagsInterface
{
    public function getTags(): TagCollectionInterface;
}
