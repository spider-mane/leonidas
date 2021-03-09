<?php

namespace WebTheory\Leonidas\Contracts\Extension;

use WebTheory\Leonidas\Framework\WpExtension;

interface ModuleInitializerInterface
{
    public function init(): void;
}
