<?php

namespace Leonidas\Framework\Bootstrappers;

use Leonidas\Contracts\Extension\WpExtensionInterface;

class AbstractBootstrapAssistant
{
    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }
}
