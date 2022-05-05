<?php

namespace Leonidas\Library\System\Model\Abstracts;

trait LazyLoadableRelationshipsTrait
{
    protected function lazyLoadable(string $property)
    {
        $method = 'get' . ucfirst($property) . 'FromRepository';

        return $this->{$property} ??= $this->{$method}();
    }

    protected function lazyLoadableNullable(string $property)
    {
        static $queried = [];

        if (!$queried[$property] ?? false) {
            $queried[$property] = true;

            return $this->lazyLoadable($property);
        }

        return $this->{$property};
    }
}
