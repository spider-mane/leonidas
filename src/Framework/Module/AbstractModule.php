<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Abstracts\InitsServerRequestTrait;
use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;
use Leonidas\Framework\Module\Abstracts\HasCallbackMethodsTrait;

abstract class AbstractModule implements ModuleInterface
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
