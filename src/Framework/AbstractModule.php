<?php

namespace WebTheory\Leonidas\Framework;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Admin\Contracts\WpExtensionInterface;

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
}
