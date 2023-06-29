<?php

namespace Leonidas\Plugin\Helper;

use Leonidas\Library\System\Configuration\Option\DeferredOptionValue;
use Leonidas\Library\System\Configuration\Option\DeferredOptionValueFactory;
use Leonidas\Plugin\Leonidas;

function option_value(string $option, mixed $default = null): DeferredOptionValue
{
    /** @var DeferredOptionValueFactory $factory */

    $factory = Leonidas::instance()->service(DeferredOptionValueFactory::class);

    return $factory->get($option, $default);
}
