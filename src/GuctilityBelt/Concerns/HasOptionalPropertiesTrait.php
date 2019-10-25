<?php

namespace WebTheory\GuctilityBelt\Concerns;

trait HasOptionalPropertiesTrait
{
    /**
     * resolve optional properties
     */
    public function resolveOptionalProperties($options)
    {
        foreach ($options as $property => $value) {
            $setter = "set_{$property}";

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } elseif (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}
