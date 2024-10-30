<?php

namespace Example\Content\Modules;

use Leonidas\Framework\Module\Abstracts\PostTypeVesselMetaboxesModule;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;

class PostMetaboxes extends PostTypeVesselMetaboxesModule
{
    use LeonidasServices;

    protected function postType(): string
    {
        return 'post';
    }

    protected function capsuleClasses(): array
    {
        return [
            //
        ];
    }
}
