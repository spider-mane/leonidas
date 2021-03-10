<?php

namespace Leonidas\Contracts\Admin;

use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\ComponentLoaderInterface;

interface MetaboxCollectionLoaderInterFace extends ComponentLoaderInterface
{
    public function addMetaBox(MetaboxInterface $metabox);
}
