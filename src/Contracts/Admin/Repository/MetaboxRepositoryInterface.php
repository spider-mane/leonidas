<?php

namespace Leonidas\Contracts\Admin\Repository;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;

interface MetaboxRepositoryInterface
{
    public function getMetabox(string $id);

    public function getMetaboxes();

    public function addMetabox(MetaboxInterface $metabox);

    public function getMetaboxesFor($screen, $context): MetaboxCollectionInterface;
}
