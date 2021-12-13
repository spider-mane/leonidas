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

    // public function get($key, $default = null)
    // {
    //     if ($this->has($key)) {
    //         $this->resolveDeferredValues($key, $this->cache[$key]);

    //         return $this->cache[$key];
    //     }

    //     return $default;
    // }

    // protected function resolveDeferredValues($key, &$value)
    // {
    //     if ($value instanceof ConfigReflectorInterface) {
    //         $value = $value->reflect($this);
    //     }

    //     if (is_array($value)) {
    //         foreach ($value as $nested => &$value) {
    //             $this->resolveDeferredValues("$key.$nested", $value);
    //         }
    //     }

    //     $this->resolved[] = $key;
    // }
}
