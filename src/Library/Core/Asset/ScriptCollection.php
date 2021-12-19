<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;

class ScriptCollection implements ScriptCollectionInterface
{
    /**
     * @var ScriptInterface[]
     */
    protected array $scripts = [];

    public function __construct(ScriptInterface ...$scripts)
    {
        array_map([$this, 'addScript'], $scripts);
    }

    /**
     * Get the value of scripts
     *
     * @return ScriptInterface[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    public function addScript(ScriptInterface $script)
    {
        $this->scripts[$script->getHandle()] = $script;
    }

    public function getScript(string $script): ScriptInterface
    {
        return $this->scripts[$script];
    }

    public function hasScript(string $script): bool
    {
        return isset($this->scripts[$script]);
    }

    public static function with(ScriptInterface ...$scripts): ScriptCollection
    {
        return new static(...$scripts);
    }
}
