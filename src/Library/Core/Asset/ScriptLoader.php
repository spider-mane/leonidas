<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;
use Psr\Http\Message\ServerRequestInterface;

class ScriptLoader implements ScriptLoaderInterface
{
    public function load(ScriptCollectionInterface $scripts, ServerRequestInterface $request)
    {
        foreach ($scripts->getScripts() as $script) {
            if ($script->shouldBeLoaded($request)) {
                if ($script->shouldBeEnqueued()) {
                    $this->enqueueScript($script);
                } else {
                    $this->registerScript($script);
                }
            }
        }
    }

    public function support(InlineScriptCollectionInterface $scripts, ServerRequestInterface $request)
    {
        foreach ($scripts->getScripts() as $script) {
            if ($script->shouldBeLoaded($request)) {
                $this->addInlineScript($script);
            }
        }
    }

    public function localize(ScriptLocalizationCollectionInterface $localizations, ServerRequestInterface $request)
    {
        foreach ($localizations->getLocalizations() as $localization) {
            if ($localization->shouldBeLoaded($request)) {
                $this->localizeScript($localization);
            }
        }
    }

    public function activate(string ...$scripts)
    {
        foreach ($scripts as $script) {
            wp_enqueue_script($script);
        }
    }

    public function deactivate(string ...$scripts)
    {
        foreach ($scripts as $script) {
            wp_dequeue_script($script);
        }
    }

    protected function registerScript(ScriptInterface $script)
    {
        wp_register_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->shouldLoadInFooter()
        );

        // $this->loadScriptAddons($script);
    }

    protected function enqueueScript(ScriptInterface $script)
    {
        wp_enqueue_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->shouldLoadInFooter()
        );

        // $this->loadScriptAddons($script);
    }

    protected function addInlineScript(InlineScriptInterface $script)
    {
        wp_add_inline_script(
            $script->getHandle(),
            $script->getCode(),
            $script->getPosition()
        );
    }

    protected function localizeScript(ScriptLocalizationInterface $localization)
    {
        wp_localize_script(
            $localization->getHandle(),
            $localization->getVariable(),
            $localization->getData()
        );
    }

    // protected function loadScriptAddons(ScriptInterface $script)
    // {
    //     if ($script->hasLocalizations()) {
    //         foreach ($script->getLocalizations()->getLocalizations() as $localization) {
    //             $this->localizeScript($localization);
    //         }
    //     }

    //     if ($script->hasInlineSupport()) {
    //         foreach ($script->getInlineSupport()->getScripts() as $inlineScript) {
    //             $this->addInlineScript($inlineScript);
    //         }
    //     }
    // }
}
