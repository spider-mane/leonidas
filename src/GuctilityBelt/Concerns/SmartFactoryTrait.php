<?php

namespace Backalley\GuctilityBelt\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;

trait SmartFactoryTrait
{
    /**
     * Get the value of namespace
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the value of namespace
     *
     * @param mixed $namespace
     *
     * @return self
     */
    public function addNamespace(string $namespace)
    {
        $this->namespace = (array) $namespace + (array) $this->namespace;

        return $this;
    }

    /**
     *
     */
    protected function build(string $class, Collection $args)
    {
        $keys = $args->keys()->transform(function ($arg) {
            return $this->getParam($arg);
        });

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $construct = [];

        foreach ($params as $param) {

            if ($keys->contains($param->name)) {

                $arg = $this->getArg($param->name);

                $construct[] = $args->get($arg);
                $args->forget($arg);
            }
        }

        $object = $reflection->newInstance(...$construct);

        foreach ($args as $property => $value) {
            $setter = $this->getSetter($property);

            if ($reflection->hasMethod($setter)) {
                $reflection->getMethod($setter)->invoke($object, $value);
            } else {
                throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}");
            }
        }

        return $object;
    }

    /**
     *
     */
    protected static function getSetter(string $property)
    {
        return 'set' . Str::studly($property);
    }

    /**
     *
     */
    protected static function getArg(string $param)
    {
        return Str::snake($param);
    }

    /**
     *
     */
    protected static function getParam(string $arg)
    {
        return Str::camel($arg);
    }

    /**
     *
     */
    protected static function getClassName(string $class)
    {
        return Str::studly($class);
    }

    /**
     *
     */
    protected static function getFqn(string $namespace, string $class)
    {
        return $namespace . '\\' . static::getClassName($class);
    }

    /**
     *
     */
    protected function getClass(string $class)
    {
        foreach ((array) $this->getNamespace() as $namespace) {

            if ((class_exists($class = $this->getFqn($namespace, $class)))) {
                return $class;
            }
        }

        return false;
    }

    /**
     *
     */
    public function __call($name, $args)
    {
        return $this->create($this->getArg($name), $args[0]);
    }

    /**
     *
     */
    public static function __callStatic($name, $args)
    {
        return (new static)->create(static::getArg($name), $args[0]);
    }
}
