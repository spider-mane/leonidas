<?php

namespace Leonidas\Contracts\Extension;

use Panamax\Contracts\ServiceContainerInterface;

interface ExtensionLoaderInterface
{
    public function getContainer(): ServiceContainerInterface;

    public function getExtension(): WpExtensionInterface;

    public function bootstrap(): void;
}
