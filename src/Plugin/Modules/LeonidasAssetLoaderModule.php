<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\AbstractAdminAssetLoaderModule;
use Leonidas\Library\Core\Asset\Script;
use Leonidas\Library\Core\Asset\Style;

final class LeonidasAssetLoaderModule extends AbstractAdminAssetLoaderModule implements ModuleInterface
{
    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $extension = $this->getExtension();
        $version = [$extension, 'vot'];
        $asset = [$extension, 'asset'];

        $saveyourDeps = ['select2', 'trix'];
        $leonidasDeps = ['jquery'];

        // styles from dependency libraries
        wp_register_style('select2', $asset('/lib/select2.min.css'), null);
        wp_register_style('trix', $asset('/lib/trix.css'), null);

        // scripts from dependency libraries
        wp_register_script('select2', $asset('/lib/select2.full.min.js'), null, null, true);
        wp_register_script('trix', $asset("/lib/trix.js"), null, null, true);
        wp_register_script('saveyour', $asset("/lib/saveyour.js"), $saveyourDeps, null, true);

        // leonidas assets
        wp_register_style('leonidas', $asset('/css/backalley-admin-styles.css'), null, $version("1.0.0"));
        wp_register_script('leonidas', $asset('/js/backalley-admin.js'), $leonidasDeps, $version("1.0.0"), true);
    }

    /**
     * @return Script[]
     */
    protected function getScriptsToRegister(): array
    {
        return [];
    }

    /**
     * @return Style[]
     */
    protected function getStylesToRegister(): array
    {
        return [];
    }
}
