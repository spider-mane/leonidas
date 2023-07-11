<?php

namespace Leonidas\Framework\Capsule;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Library\Admin\Component\Metabox\MetaboxCollection;
use Leonidas\Library\Admin\Vessel\MetaboxVessel;

class MetaboxCapsuleInitiator
{
    public function __construct(protected WpExtensionInterface $extension)
    {
        //
    }

    /**
     * @param class-string $capsules
     */
    public function initiate(string ...$capsules): MetaboxCollectionInterface
    {
        $callback = fn ($capsule) => new MetaboxVessel(
            new $capsule($this->extension)
        );

        return new MetaboxCollection(...array_map($callback, $capsules));
    }
}
