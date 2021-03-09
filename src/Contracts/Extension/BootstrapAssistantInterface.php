<?php

namespace WebTheory\Leonidas\Contracts\Extension;

use WebTheory\Leonidas\Admin\Contracts\WpExtensionInterface;

interface BootstrapAssistantInterface
{
    public function __construct(WpExtensionInterface $extension);

    public function boot(): void;
}
