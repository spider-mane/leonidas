<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface MetaboxCollectionLoaderInterFace extends ComponentLoaderInterface
{
    public function addMetaBox(MetaboxInterface $metabox);
}
