<?php

namespace WebTheory\Leonidas\Contracts\Admin;

use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxInterface;
use WebTheory\Leonidas\Contracts\Admin\MetaboxCollectionInterface;

interface MetaboxRepositoryInterface
{
    public function getMetabox(string $id);

    public function getMetaboxes();

    public function addMetabox(MetaboxInterface $metabox);

    public function getMetaboxesFor($screen, $context): MetaboxCollectionInterface;
}
