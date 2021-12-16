<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;

class InlineScriptBuilder extends AbstractInlineAssetBuilder
{
    protected string $position;

    public function position(string $position): InlineScriptBuilder
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function done(): InlineScriptInterface
    {
        return new InlineScript(
            $this->getHandle(),
            $this->getData(),
            $this->getPosition(),
            $this->getConstraints(),
        );
    }

    public static function for(string $handle): InlineScriptBuilder
    {
        return new static($handle);
    }
}
