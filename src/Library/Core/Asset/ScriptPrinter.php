<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptPrinterInterface;
use WebTheory\Html\Html;

class ScriptPrinter implements ScriptPrinterInterface
{
    public function print(ScriptInterface $script): string
    {
        return Html::tag('script', [
            'src' => $this->getSrcAttribute($script),
            'id' => $this->getIdAttribute($script),
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

    public function merge(string $tag, ScriptInterface $script): string
    {
        return $this->print($script);
    }

    protected function getIdAttribute(ScriptInterface $script): string
    {
        return "{$script->getHandle()}-js";
    }

    protected function getSrcAttribute(ScriptInterface $script): string
    {
        return (null !== $script->getVersion())
            ? "{$script->getSrc()}?ver={$script->getVersion()}"
            : $script->getSrc();
    }
}
