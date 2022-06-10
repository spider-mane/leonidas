<?php

namespace Leonidas\Contracts\Extension;

use Panamax\Contracts\ServiceContainerInterface;
use WebTheory\Config\Interfaces\ConfigInterface;

interface ExtensionLoaderInterface
{
    public function bootstrap(): void;

    public function getContainer(): ServiceContainerInterface;

    public function getConfig(): ConfigInterface;

    public function getExtension(): WpExtensionInterface;

    public function error(): void;
}
