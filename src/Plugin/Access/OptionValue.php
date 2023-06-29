<?php

namespace Leonidas\Plugin\Access;

use Leonidas\Library\System\Configuration\Option\DeferredOptionValue;
use Leonidas\Library\System\Configuration\Option\DeferredOptionValueFactory;

/**
 * @method static DeferredOptionValue get(string $option, mixed $default = null)
 */
class OptionValue extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return DeferredOptionValueFactory::class;
    }
}
