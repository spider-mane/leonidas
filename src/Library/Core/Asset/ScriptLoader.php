<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;

class ScriptLoader implements ScriptLoaderInterface
{
    protected ScriptCollectionInterface $scripts;

    protected InlineScriptCollectionInterface $inlineScripts;

    public function __construct(ScriptCollectionInterface $scripts, InlineScriptCollectionInterface $inlineScripts)
    {
        $this->scripts = $scripts;
        $this->inlineScripts = $inlineScripts;
    }

    protected function getScripts(): ScriptCollectionInterface
    {
        return $this->scripts;
    }

    protected function getInlineScripts(): InlineScriptCollectionInterface
    {
        return $this->inlineScripts;
    }

    public function load(ServerRequestInterface $request)
    {
        foreach ($this->getScripts()->getScripts() as $script) {
            if ($script->shouldBeLoaded($request)) {
                if ($script->shouldBeEnqueued()) {
                    $this->enqueueScript($script);
                } else {
                    $this->registerScript($script);
                }
            }
        }
    }

    public function loadInline(ServerRequestInterface $request)
    {
        foreach ($this->getInlineScripts()->getScripts() as $script) {
            if ($script->shouldBeLoaded($request)) {
                $this->addInlineScript($script);
            }
        }
    }

    public static function registerScript(ScriptInterface $script)
    {
        wp_register_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->shouldLoadInFooter()
        );
    }

    public static function enqueueScript(ScriptInterface $script)
    {
        wp_enqueue_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->shouldLoadInFooter()
        );
    }

    public static function addInlineScript(InlineScriptInterface $script)
    {
        wp_add_inline_script(
            $script->getHandle(),
            $script->getData(),
            $script->getPosition()
        );
    }

    public static function createScriptTag(ScriptInterface $script): string
    {
        return Html::tag('script', [
            'src' => static::getSrcAttribute($script),
            'id' => static::getIdAttribute($script),
            'async' => $script->isAsync(),
            'crossorigin' => $script->getCrossorigin(),
            'defer' => $script->isDeferred(),
            'integrity' => $script->getIntegrity(),
            'nomodule' => $script->isNoModule(),
            'nonce' => $script->getNonce(),
            'rererrerpolicy' => $script->getReferrerPolicy(),
            'type' => $script->getType(),
        ] + $script->getAttributes()) . "\n";
    }

    public static function mergeScriptTag(string $tag, ScriptInterface $script): string
    {
        return static::createScriptTag($script);
    }

    public static function getIdAttribute(ScriptInterface $script): string
    {
        return "{$script->getHandle()}-js";
    }

    public static function getSrcAttribute(ScriptInterface $script): string
    {
        return (null !== $script->getVersion())
            ? "{$script->getSrc()}?ver={$script->getVersion()}"
            : $script->getSrc();
    }
}
