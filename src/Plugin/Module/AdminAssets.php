<?php

namespace Leonidas\Plugin\Module;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Framework\Module\Abstracts\AdminAssetProviderModule;
use Leonidas\Library\Core\Asset\ScriptBuilder;
use Leonidas\Library\Core\Asset\ScriptCollection;
use Leonidas\Library\Core\Asset\StyleBuilder;
use Leonidas\Library\Core\Asset\StyleCollection;

final class AdminAssets extends AdminAssetProviderModule
{
    protected function scripts(): ScriptCollectionInterface
    {
        return ScriptCollection::from([

            ScriptBuilder::for('leonidas')
                ->src($this->asset('js/leonidas.js'))
                ->version($this->version())
                ->dependencies('jquery', 'leonidas-manifest', 'leonidas-vendors')
                ->inFooter(true)
                ->enqueue(true)
                ->done(),

            ScriptBuilder::for('leonidas-manifest')
                ->src($this->asset('js/manifest.js'))
                ->version($this->version())
                ->inFooter(true)
                ->done(),

            ScriptBuilder::for('leonidas-vendors')
                ->src($this->asset('js/vendor.js'))
                ->version($this->version())
                ->dependencies('leonidas-manifest')
                ->inFooter(true)
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

        ]);
    }

    protected function styles(): StyleCollectionInterface
    {
        return StyleCollection::from([

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

        ]);
    }
}
