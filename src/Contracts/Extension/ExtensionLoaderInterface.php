<?php

namespace Leonidas\Contracts\Extension;

use Panamax\Contracts\ServiceContainerInterface;

interface ExtensionLoaderInterface
{
    public function bootstrap(): void;

    public function getContainer(): ServiceContainerInterface;

    public function getExtension(): WpExtensionInterface;

    public function error(): void;
}
