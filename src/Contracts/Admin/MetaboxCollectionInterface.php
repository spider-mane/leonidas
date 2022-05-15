<?php

namespace Leonidas\Contracts\Admin;

use Leonidas\Contracts\Admin\Component\MetaboxInterface;

interface MetaboxCollectionInterface
{
    public function getMetabox(string $metabox): MetaboxInterface;

    /**
     * @return MetaboxInterface[]
     */
    public function getMetaboxes(): array;

    public function hasMetabox(string $metabox): bool;
}
