<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Library\Core\Util\ClassConst;

trait HasExaltedConfigurationTrait
{
    use HasModuleConfigurationTrait;

    protected function moduleConfigKey(): string
    {
        return ClassConst::required($this, 'MODULE');
    }
}
