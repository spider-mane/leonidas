<?php

namespace Leonidas\Contracts\Extension\App;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;

interface AppLoaderInterface extends ExtensionLoaderInterface
{
    /**
     * For bootstrapping integration with system
     */
    public function integrate(): void;
}
