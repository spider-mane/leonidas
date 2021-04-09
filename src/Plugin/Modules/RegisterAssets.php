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
        $version = [$extension, 'vot'];

        $saveyourJsDeps = ['select2', 'trix'];
        $leonidasJsDeps = ['jquery'];

        // styles from dependency libraries
        wp_enqueue_style('select2', $assets('lib/select2/select2.min.css'), null);
        wp_enqueue_style('trix', $assets('lib/trix/trix.css'), null);

        // scripts from dependency libraries
        wp_enqueue_script('select2', $assets('lib/select2/select2.full.min.js'), null, null, true);
        wp_enqueue_script('trix', $assets('lib/trix/trix.js'), null, null, true);
        wp_enqueue_script('saveyour', $assets('lib/saveyour/saveyour.js'), $saveyourJsDeps, null, true);

        // plugin assets
        wp_enqueue_style('leonidas', $assets('css/backalley-admin-styles.css'), null, $version());
        wp_enqueue_script('leonidas', $assets('js/backalley-admin.js'), $leonidasJsDeps, $version(), true);
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
