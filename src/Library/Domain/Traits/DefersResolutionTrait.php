<?php

namespace Library\Wp\Domain\Traits;

trait DefersResolutionTrait
{
    protected function resolveValue(string $property)
    {
        if (!isset($this->$property)) {
            $setter = 'set' . ucfirst($property);
            $getter = 'get' . ucfirst($property);

            ($this->$setter)(($this->provider->$getter)());
        }

        return $this->$property;
    }
}
