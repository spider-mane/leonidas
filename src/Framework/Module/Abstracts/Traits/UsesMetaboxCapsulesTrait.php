<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Capsule\MetaboxCapsuleInitiator;

trait UsesMetaboxCapsulesTrait
{
    use RequiresCapsuleClassesTrait;

    protected function metaboxes(): MetaboxCollectionInterface
    {
        $initiator = new MetaboxCapsuleInitiator($this->getExtension());

        return $initiator->initiate(...$this->capsuleClasses());
    }

    abstract protected function getExtension(): WpExtensionInterface;
}
