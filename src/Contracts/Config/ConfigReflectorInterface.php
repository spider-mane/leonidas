<?php

namespace Leonidas\Contracts\Config;

use Noodlehaus\ConfigInterface;

interface ConfigReflectorInterface
{
    public function reflect(ConfigInterface $config);
}
