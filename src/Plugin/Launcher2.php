<?php

namespace Leonidas\Plugin;

use Leonidas\Framework\Plugin\Abstracts\PluginLauncherTrait;

final class Launcher2
{
    use PluginLauncherTrait;

    private function launch(): void
    {
        $this->launchExtension()->declareExtensionLoaded();
    }

    private function launchExtension(): self
    {
        Leonidas::init($this->extension);

        return $this;
    }

    private function declareExtensionLoaded(): void
    {
        do_action('leonidas_loaded');
    }

    private static function headers(): string
    {
        return 'LEONIDAS_PLUGIN_HEADERS';
    }
}
