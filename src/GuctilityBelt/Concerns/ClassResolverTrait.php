<?php

namespace WebTheory\GuctilityBelt\Concerns;

use Illuminate\Support\Str;

trait ClassResolverTrait
{
    /**
     *
     */
    protected function getClassName(string $class)
    {
        $class = Str::studly($class);

        if (null !== static::CONVENTION) {
            $class = sprintf(static::CONVENTION, $class);
        }

        return $class;
    }

    /**
     *
     */
    protected function getFqn(string $namespace, string $class)
    {
        return $namespace . '\\' . $this->getClassName($class);
    }

    /**
     *
     */
    protected function getClass(string $arg)
    {
        foreach ($this->namespaces as $namespace) {

            $class = $this->getFqn($namespace, $arg);

            if (class_exists($class)) {
                return $class;
            }
        }

        return false;
    }
}
