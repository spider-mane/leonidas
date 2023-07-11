<?php

namespace Leonidas\Framework\Capsule;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Library\Admin\Vessel\MetaboxVessel;

class ConfigurableMetaboxCapsuleInitiator
{
    public function __construct(protected WpExtensionInterface $extension)
    {
        //
    }

    public function initiate(
        string $id,
        string $title,
        string $screen,
        string $context,
        string $capsule
    ): MetaboxInterface {
        return new MetaboxVessel(new $capsule($id, $title, $screen, $context));
    }
}
