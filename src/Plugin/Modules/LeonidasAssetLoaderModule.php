<?php

namespace WebTheory\Leonidas\Plugin\Modules;

use WebTheory\Leonidas\Library\Core\Asset\Script;
use WebTheory\Leonidas\Library\Core\Asset\Style;
use WebTheory\Leonidas\Contracts\Extension\ModuleInterface;
use WebTheory\Leonidas\Framework\Modules\AbstractAdminAssetLoaderModule;

final class LeonidasAssetLoaderModule extends AbstractAdminAssetLoaderModule implements ModuleInterface
{
    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $ext = $this->getExtension();
        $saveyourDeps = ['select2', 'trix'];

        // wp included libraries
        // wp_enqueue_script('jquery');

        // styles from dependency libraries
        wp_register_style('select2', $ext->asset('/lib/select2.min.css'), null);
        wp_register_style('trix', $ext->asset('/lib/trix.css'), null);

        // scripts from dependency libraries
        wp_register_script('select2', $ext->asset('/lib/select2.full.min.js'), null, $ext->vot(), true);
        wp_register_script('trix', $ext->asset("/lib/trix.js"), null, $ext->vot(), true);
        wp_register_script('saveyour', $ext->asset("/lib/saveyour.js"), $saveyourDeps, $ext->vot(), true);

        // plugin core assets
        wp_register_style('leonidas', $ext->asset('/css/backalley-admin-styles.css'), null, $ext->vot());
        wp_register_script('leonidas', $ext->asset('/js/backalley-admin.js'), null, $ext->vot(), true);
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
