<?php

namespace Leonidas\Framework\Capsule\Abstracts;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;

abstract class AbstractCapsule
{
    use UtilizesExtensionTrait;

    public function __construct(protected WpExtensionInterface $extension)
    {
        //
    }

    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }
}
