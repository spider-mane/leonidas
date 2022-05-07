<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Modules\Traits\HasCallbackMethodsTrait;
use Leonidas\Framework\Traits\UtilizesExtensionTrait;

abstract class AbstractModule implements ModuleInterface
{
    use HasCallbackMethodsTrait;
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
