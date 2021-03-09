<?php

namespace WebTheory\Leonidas\Contracts\Admin;

use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxInterface;
use WebTheory\Leonidas\Contracts\Admin\ComponentLoaderInterface;

interface MetaboxCollectionLoaderInterFace extends ComponentLoaderInterface
{
    public function addMetaBox(MetaboxInterface $metabox);
}
