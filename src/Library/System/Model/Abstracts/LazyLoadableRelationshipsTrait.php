<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Closure;
use Leonidas\Contracts\Util\AutoInvokerInterface;

trait LazyLoadableRelationshipsTrait
{
    protected AutoInvokerInterface $autoInvoker;

    protected function lazyLoadableNullable(string $property, ?Closure $callback = null): ?object
    {
        static $loaded;

        $loaded ??= [];

        if (!$loaded[$property] ?? false) {
            $loaded[$property] = true;

            return $this->lazyLoadable($property, $callback);
        }

        return $this->{$property};
    }

    protected function lazyLoadable(string $property, ?Closure $callback = null): object
    {
        return $this->{$property} ??= $this->autoInvoker->invoke(
            $callback ?? [$this, 'fetch' . ucfirst($property)]
        );
    }
}
