<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Framework\Abstracts\UtilizesExtensionTrait;
use Leonidas\Library\Core\Util\ClassConst;

trait HasModuleConfigurationTrait
{
    use UtilizesExtensionTrait;

    protected function moduleConfig(string $key, $default = null)
    {
        return $this->getConfig(
            $this->moduleConfigKey() . '.' . $key,
            $default
        );
    }

    protected function configured(string $key, string $backup, $default = null)
    {
        return $this->getConfig($this->moduleConfig($key, $backup), $default);
    }

    protected function moduleConfigKey(): string
    {
        return 'modules.' . ClassConst::required($this, 'MODULE');
    }
}
