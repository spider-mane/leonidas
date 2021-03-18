<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Contracts\Admin\ComponentLoaderInterface;
use Leonidas\Contracts\Admin\Components\MetaboxInterface;

interface MetaboxCollectionLoaderInterFace extends ComponentLoaderInterface
{
    public function addMetabox(MetaboxInterface $metabox);
}
