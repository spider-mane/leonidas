<?php

namespace Leonidas\Contracts\Extension;

use Leonidas\Framework\WpExtension;

interface ModuleInitializerInterface
{
    public function init(): void;
}
