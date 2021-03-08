<?php

namespace WebTheory\Leonidas\Framework\Contracts;

use WebTheory\Leonidas\Framework\WpExtension;

interface ModuleInitializerInterface
{
    public function init(): ModuleInitializerInterface;
}
