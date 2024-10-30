<?php

namespace Example\Plugin\Modules;

use Leonidas\Framework\Module\Abstracts\PostTypeVesselMetaboxesModule;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;

class PostMetaboxes extends PostTypeVesselMetaboxesModule
{
    use LeonidasServices;

    protected function postType(): string
    {
        return 'page';
    }

    protected function capsuleClasses(): array
    {
        return [
            //
        ];
    }
}
