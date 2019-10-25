<?php

namespace WebTheory\GuctilityBelt\Concerns;

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
    public function getNamespaces(): array
    {
        return $this->namespaces;
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
        $this->namespaces[] = $namespace;

        return $this;
    }

    /**
     *
     */
    public function addNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces + $this->namespaces;

        return $this;
    }

    /**
     *
     */
    protected function build(string $class, Collection $args)
    {
        $keys = $args->keys()->transform(function ($arg) {
            return static::getParam($arg);
        });

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $construct = [];

        foreach ($params as $param) {

            if ($keys->contains($param->name)) {

                $arg = static::getArg($param->name);

                $construct[] = $args->get($arg);
                $args->forget($arg);
            } else {
                $construct[] = null;
            }
        }

        $object = $reflection->newInstance(...$construct);

        foreach ($args as $property => $value) {
            $setter = static::getSetter($property);

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
    public function __call($name, $args)
    {
        return $this->create(static::getArg($name), $args[0]);
    }

    /**
     *
     */
    public static function __callStatic($name, $args)
    {
        return (new static)->create(static::getArg($name), $args[0]);
    }
}
