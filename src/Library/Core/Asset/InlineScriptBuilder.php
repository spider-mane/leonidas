<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineScriptBuilderInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;

class InlineScriptBuilder extends AbstractInlineAssetBuilder implements InlineScriptBuilderInterface
{
    protected string $position;

    /**
     * @return $this
     */
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
            $this->getCode(),
            $this->getPosition(),
            $this->getPolicy(),
        );
    }

    public static function for(string $handle): InlineScriptBuilder
    {
        return new static($handle);
    }
}
