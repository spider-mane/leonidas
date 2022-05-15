<?php

namespace Leonidas\Contracts\Admin;

use Leonidas\Contracts\Admin\Component\MetaboxInterface;

interface MetaboxRepositoryInterface
{
    public function getMetabox(string $id);

    public function getMetaboxes();

    public function addMetabox(MetaboxInterface $metabox);

    public function getMetaboxesFor($screen, $context): MetaboxCollectionInterface;
}
