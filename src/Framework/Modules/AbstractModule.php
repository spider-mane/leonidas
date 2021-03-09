<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Contracts\Extension\ModuleInterface;
use WebTheory\Leonidas\Contracts\Extension\WpExtensionInterface;

abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var WpExtensionInterface
     */
    protected $extension;

    /**
     * @param WpExtensionInterface $extension
     */
    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get the value of extension
     *
     * @return WpExtensionInterface
     */
    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }
}