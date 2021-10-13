<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Psr\Http\Message\ServerRequestInterface;

class ScriptLoader
{
    /**
     * @var ScriptCollectionInterface
     */
    protected $scripts = [];

    public function __construct(ScriptCollectionInterface $scripts)
    {
        $this->scripts = $scripts;
    }

    /**
     * @return array
     */
    protected function getScripts(): array
    {
        return $this->scripts->getScripts();
    }

    public function registerScript(ScriptInterface $script)
    {
        wp_register_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->loadInFooter()
        );
    }

    public function register(): void
    {
        foreach ($this->getScripts() as $script) {
            $this->registerScript($script);
        }
    }

    public function registerIf(ServerRequestInterface $request)
    {
        foreach ($this->getScripts() as $script) {
            if ($script->shouldBeRegistered($request)) {
                $this->registerScript($script);
            }
        }
    }

    public function enqueueScript(ScriptInterface $script)
    {
        wp_enqueue_script(
            $script->getHandle(),
            $script->getSrc(),
            $script->getDependencies(),
            $script->getVersion(),
            $script->loadInFooter()
        );
    }

    public function enqueue(): void
    {
        foreach ($this->getScripts() as $script) {
            $this->enqueueScript($script);
        }
    }

    public function enqueueIf(ServerRequestInterface $request)
    {
        foreach ($this->getScripts() as $script) {
            if ($script->shouldBeRegistered($request)) {
                $this->registerScript($script);
            }
        }
    }

    public function createScriptTag(string $script)
    {
        return $this->scripts->getScript($script)->toHtml();
    }
}
