<?php

namespace WebTheory\Leonidas\Framework;

use WebTheory\Leonidas\Contracts\ModuleInterface;

abstract class AbstractModule implements ModuleInterface
{
    /**
     * @var WpExtension
     */
    protected $extension;

    /**
     * @param WpExtension $extension
     */
    public function __construct(WpExtension $extension)
    {
        $this->extension = $extension;
    }
}
