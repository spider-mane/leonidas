<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;

class InlineScriptCollection implements InlineScriptCollectionInterface
{
    /**
     * @var InlineScriptInterface[]
     */
    protected array $scripts = [];

    public function __construct(InlineScriptInterface ...$scripts)
    {
        array_map([$this, 'addScript'], $scripts);
    }

    /**
     * Get the value of scripts
     *
     * @return InlineScriptInterface[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    public function addScript(InlineScriptInterface $script)
    {
        $this->scripts[] = $script;
    }

    public function getScript(string $script): InlineScriptInterface
    {
        return $this->scripts[$script];
    }

    public function hasScript(string $script): bool
    {
        return isset($this->scripts[$script]);
    }

    public static function with(InlineScriptInterface ...$scripts): InlineScriptCollection
    {
        return new static(...$scripts);
    }

    public static function from(array $scripts): InlineScriptCollection
    {
        return new static(...$scripts);
    }
}
