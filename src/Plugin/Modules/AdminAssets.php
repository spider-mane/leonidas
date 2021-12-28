<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Framework\Modules\AbstractAdminAssetProviderModule;
use Leonidas\Library\Core\Asset\ScriptBuilder;
use Leonidas\Library\Core\Asset\ScriptCollection;
use Leonidas\Library\Core\Asset\StyleBuilder;
use Leonidas\Library\Core\Asset\StyleCollection;

final class AdminAssets extends AbstractAdminAssetProviderModule implements ModuleInterface
{
    protected function scripts(): ScriptCollectionInterface
    {
        return ScriptCollection::with(

            ScriptBuilder::for('leonidas')
                ->src($this->asset('js/leonidas.js'))
                ->version($this->version())
                ->dependencies('jquery')
                ->inFooter(true)
                ->enqueue(true)
                ->done(),

            // 3rd party
            ScriptBuilder::for('saveyour')
                ->src($this->asset('lib/saveyour/saveyour.js'))
                ->dependencies('select2', 'choices', 'trix')
                ->inFooter(true)
                ->enqueue(true)
                ->done(),

            ScriptBuilder::for('select2')
                ->src($this->asset('lib/select2/select2.full.min.js'))
                ->inFooter(true)
                ->done(),

            ScriptBuilder::for('choices')
                ->src($this->asset('lib/choices/choices.min.js'))
                ->inFooter(true)
                ->done(),

            ScriptBuilder::for('trix')
                ->src($this->asset('lib/trix/trix.js'))
                ->inFooter(true)
                ->done(),
        );
    }

    protected function styles(): StyleCollectionInterface
    {
        return StyleCollection::with(

            StyleBuilder::for('leonidas')
                ->src($this->asset('css/leonidas.css'))
                ->version($this->version())
                ->enqueue(true)
                ->done(),

            // 3rd party
            StyleBuilder::for('select2')
                ->src($this->asset('lib/select2/select2.min.css'))
                ->enqueue(true)
                ->done(),

            StyleBuilder::for('choices')
                ->src($this->asset('lib/choices/choices.min.css'))
                ->enqueue(true)
                ->done(),

            StyleBuilder::for('trix')
                ->src($this->asset('lib/trix/trix.css'))
                ->enqueue(true)
                ->done(),
        );
    }
}
