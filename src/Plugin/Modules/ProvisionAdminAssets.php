<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Framework\Modules\AbstractAdminAssetProvisionModule;
use Leonidas\Library\Core\Asset\ScriptBuilder;
use Leonidas\Library\Core\Asset\ScriptCollection;
use Leonidas\Library\Core\Asset\StyleBuilder;
use Leonidas\Library\Core\Asset\StyleCollection;

final class ProvisionAdminAssets extends AbstractAdminAssetProvisionModule implements ModuleInterface
{
    protected function getScriptsToProvision(): ?ScriptCollectionInterface
    {
        $ext = $this->getExtension();
        $assets = [$ext, 'asset'];
        $vot = [$ext, 'vot'];

        return new ScriptCollection(
            ScriptBuilder::start('leonidas')
                ->setSrc($assets('js/backalley-admin.js'))
                ->setVersion($vot())
                ->setDependencies('jquery')
                ->setLoadInFooter(true)
                ->create(),

            // 3rd party
            ScriptBuilder::start('select2')
                ->setSrc($assets('lib/select2/select2.full.min.js'))
                ->setLoadInFooter(true)
                ->create(),

            ScriptBuilder::start('trix')
                ->setSrc($assets('lib/trix/trix.js'))
                ->setLoadInFooter(true)
                ->create(),

            ScriptBuilder::start('saveyour')
                ->setSrc($assets('lib/saveyour/saveyour.js'))
                ->setDependencies('select2', 'trix')
                ->setLoadInFooter(true)
                ->create(),
        );
    }

    protected function getStylesToProvision(): ?StyleCollectionInterface
    {
        $ext = $this->getExtension();
        $assets = [$ext, 'asset'];
        $vot = [$ext, 'vot'];

        return new StyleCollection(
            StyleBuilder::start('leonidas')
                ->setSrc($assets('css/backalley-admin-styles.css'))
                ->setVersion($vot())
                ->create(),

            // 3rd party
            StyleBuilder::start('select2')
                ->setSrc($assets('lib/select2/select2.min.css'))
                ->create(),

            StyleBuilder::start('trix')
                ->setSrc($assets('lib/trix/trix.css'))
                ->create(),
        );
    }
}
