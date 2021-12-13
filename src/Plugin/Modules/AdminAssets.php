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

final class AdminAssets extends AbstractAdminAssetProvisionModule implements ModuleInterface
{
    protected function scripts(): ?ScriptCollectionInterface
    {
        return new ScriptCollection(
            ScriptBuilder::prepare('leonidas')
                ->setSrc($this->asset('js/backalley-admin.js'))
                ->setVersion($this->vot())
                ->setDependencies('jquery')
                ->setShouldLoadInFooter(true)
                ->build(),

            // 3rd party
            ScriptBuilder::prepare('select2')
                ->setSrc($this->asset('lib/select2/select2.full.min.js'))
                ->setShouldLoadInFooter(true)
                ->build(),

            ScriptBuilder::prepare('trix')
                ->setSrc($this->asset('lib/trix/trix.js'))
                ->setShouldLoadInFooter(true)
                ->build(),

            ScriptBuilder::prepare('saveyour')
                ->setSrc($this->asset('lib/saveyour/saveyour.js'))
                ->setDependencies('select2', 'trix')
                ->setShouldLoadInFooter(true)
                ->build(),
        );
    }

    protected function styles(): ?StyleCollectionInterface
    {
        return new StyleCollection(
            StyleBuilder::prepare('leonidas')
                ->setSrc($this->asset('css/backalley-admin-styles.css'))
                ->setVersion($this->vot())
                ->build(),

            // 3rd party
            StyleBuilder::prepare('select2')
                ->setSrc($this->asset('lib/select2/select2.min.css'))
                ->build(),

            StyleBuilder::prepare('trix')
                ->setSrc($this->asset('lib/trix/trix.css'))
                ->build(),
        );
    }
}
