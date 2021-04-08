<?php

namespace Leonidas\Library\Core\Config;

use Leonidas\Contracts\Config\ConfigReflectorInterface;
use Noodlehaus\ConfigInterface;
use Noodlehaus\Parser\ParserInterface;
use WebTheory\GuctilityBelt\Config as GuctilityBeltConfig;

class Config extends GuctilityBeltConfig implements ConfigInterface
{
    protected function loadFromFile($path, ?ParserInterface $parser = null)
    {
        parent::loadFromFile($path, $parser);
        $this->resolveReflections();
    }

    protected function resolveReflections()
    {
        array_walk_recursive($this->data, function (&$entry) {
            if ($entry instanceof ConfigReflectorInterface) {
                $entry = $entry->reflect($this);
            }
        });
    }
}
