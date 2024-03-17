<?php

namespace Leonidas\Plugin\Functions\Config;

use Leonidas\Library\System\Configuration\Option\DeferredOptionValue;
use Leonidas\Library\System\Configuration\Option\DeferredOptionValueFactory;
use Leonidas\Plugin\Leonidas;

function option(string $option, mixed $default = null): DeferredOptionValue
{
    static $factory;

    $factory ??= Leonidas::getService(DeferredOptionValueFactory::class);

    /** @var DeferredOptionValueFactory $factory */

    return $factory->get($option, $default);
}
