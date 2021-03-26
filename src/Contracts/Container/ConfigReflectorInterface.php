<?php

namespace Leonidas\Contracts\Container;

use Noodlehaus\ConfigInterface;

interface ConfigReflectorInterface
{
    public function reflect(ConfigInterface $config);
}
