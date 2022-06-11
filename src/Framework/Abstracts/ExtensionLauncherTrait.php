<?php

namespace Leonidas\Framework\Abstracts;

trait ExtensionLauncherTrait
{
    use ExtensionLoaderTrait {
        bootstrap as initiate;
    }

    private function bootstrap(): void
    {
        $this->initiate();
        $this->launch();
    }

    private function launch(): void
    {
        //
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance);
    }
}
