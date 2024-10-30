<?php

namespace Example\Content\Modules;

use Example\Content\Metaboxes\StatementMetabox;
use Leonidas\Framework\Module\Abstracts\PostTypeVesselMetaboxesModule;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;

class StatementMetaboxes extends PostTypeVesselMetaboxesModule
{
    use LeonidasServices;

    protected function postType(): string
    {
        return $this->key('statement');
    }

    protected function capsuleClasses(): array
    {
        return [
            StatementMetabox::class,
        ];
    }
}
