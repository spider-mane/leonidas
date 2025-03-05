<?php

namespace Example\Content\Modules;

use Example\Content\Metaboxes\CopyMetabox;
use Leonidas\Framework\Module\Abstracts\PostTypeVesselMetaboxesModule;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;

class CopyMetaboxes extends PostTypeVesselMetaboxesModule
{
    use LeonidasServices;

    protected function postType(): string
    {
        return $this->key('copy');
    }

    protected function capsuleClasses(): array
    {
        return [
            CopyMetabox::class,
        ];
    }
}
