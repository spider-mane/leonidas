<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\AbstractAdminAssetLoaderModule;
use Leonidas\Library\Core\Asset\Script;
use Leonidas\Library\Core\Asset\Style;

final class RegisterAssets extends AbstractAdminAssetLoaderModule implements ModuleInterface
{
    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $extension = $this->getExtension();
        $assets = [$extension, 'asset'];
        $vot = [$extension, 'vot'];

        $saveyourJsDeps = ['select2', 'trix'];
        $leonidasJsDeps = ['jquery'];

        // styles from dependency libraries
        wp_register_style('select2', $assets('/lib/select2/select2.min.css'), null);
        wp_register_style('trix', $assets('/lib/trix/trix.css'), null);

        // scripts from dependency libraries
        wp_register_script('select2', $assets('/lib/select2/select2.full.min.js'), null, null, true);
        wp_register_script('trix', $assets("/lib/trix/trix.js"), null, null, true);
        wp_register_script('saveyour', $assets("/lib/saveyour/saveyour.js"), $saveyourJsDeps, null, true);

        // plugin assets
        wp_register_style('leonidas', $assets('/css/backalley-admin-styles.css'), null, $vot("1.0.0"));
        wp_register_script('leonidas', $assets('/js/backalley-admin.js'), $leonidasJsDeps, $vot("1.0.0"), true);
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
