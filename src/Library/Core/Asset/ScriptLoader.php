<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;

class ScriptLoader implements ScriptLoaderInterface
{
    /**
     * @var ScriptCollectionInterface
     */
    protected $scripts;

    public function __construct(ScriptCollectionInterface $scripts)
    {
        $this->scripts = $scripts;
    }

    protected function getScripts(): ScriptCollectionInterface
    {
        return $this->scripts;
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
