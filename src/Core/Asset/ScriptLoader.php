<?php

namespace WebTheory\Leonidas\Core\Asset;

use WebTheory\Leonidas\Core\Contracts\ScriptInterface;

class ScriptLoader
{
    /**
     * @var ScriptInterface[]
     */
    protected $scripts = [];

    public function __construct(ScriptInterface ...$scripts)
    {
        $this->scripts = $scripts;
    }

    /**
     * @return ScriptInterface[]
     */
    protected function getScripts(): array
    {
        return $this->scripts;
    }

    public function enqueue(): void
    {
        foreach ($this->getScripts() as $script) {
            wp_enqueue_script(
                $script->getHandle(),
                $script->getSrc(),
                $script->getDeps(),
                $script->getVersion(),
                $script->loadInFooter()
            );
        }
    }

    public function register(): void
    {
        foreach ($this->getScripts() as $script) {
            wp_register_script(
                $script->getHandle(),
                $script->getSrc(),
                $script->getDeps(),
                $script->getVersion(),
                $script->loadInFooter()
            );
        }
    }
}
