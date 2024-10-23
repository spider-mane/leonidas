<?php

namespace Leonidas\Contracts\System\Model\Tag;

interface HasManyMutableTagsInterface extends HasManyTagsInterface
{
    /**
     * @return $this
     */
    public function setTags(TagCollectionInterface $tags): self;

    /**
     * @return $this
     */
    public function addTags(TagInterface ...$tags): self;

    /**
     * @return $this
     */
    public function mergeTags(TagCollectionInterface $tags): self;
}
