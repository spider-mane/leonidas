<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Contracts\Admin\ComponentLoaderInterface;

interface MetaboxCollectionLoaderInterFace extends ComponentLoaderInterface
{
    public function addMetabox(MetaboxInterface $metabox);
}
