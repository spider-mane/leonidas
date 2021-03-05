<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface MetaboxRepositoryInterface
{
    public function getMetabox(string $id);

    public function getMetaboxes();

    public function addMetabox(MetaboxInterface $metabox);

    public function getMetaboxesFor($screen, $context): MetaboxCollectionInterface;
}
