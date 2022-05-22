<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Abstracts\HasCallbackMethodsTrait;
use Leonidas\Framework\Abstracts\InitsServerRequestTrait;
use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;

abstract class Module implements ModuleInterface
{
    use HasCallbackMethodsTrait;
    use InitsServerRequestTrait;
    use UtilizesExtensionTrait;

    protected WpExtensionInterface $extension;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    protected function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    public static function instance(WpExtensionInterface $extension): ModuleInterface
    {
        return new static($extension);
    }
}
