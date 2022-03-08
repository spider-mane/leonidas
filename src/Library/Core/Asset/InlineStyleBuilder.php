<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineStyleInterface;

class InlineStyleBuilder extends AbstractInlineAssetBuilder
{
    public function done(): InlineStyleInterface
    {
        return new InlineStyle(
            $this->getHandle(),
            $this->getCode(),
            $this->getPolicy()
        );
    }

    public static function for(string $handle): InlineStyleBuilder
    {
        return new static($handle);
    }
}
