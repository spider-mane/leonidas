<?php

namespace Example\Content\Modules;

use Example\Content\Metaboxes\SectionMetabox;
use Leonidas\Framework\Module\Abstracts\PostTypeVesselMetaboxesModule;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;

class SectionMetaboxes extends PostTypeVesselMetaboxesModule
{
    use LeonidasServices;

    protected function postType(): string
    {
        return $this->key('section');
    }

    protected function capsuleClasses(): array
    {
        return [
            SectionMetabox::class,
        ];
    }
}
