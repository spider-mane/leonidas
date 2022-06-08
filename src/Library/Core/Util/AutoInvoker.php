<?php

namespace Leonidas\Library\Core\Util;

use Closure;
use InvalidArgumentException;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Psr\Container\ContainerInterface;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;
use Throwable;

class AutoInvoker implements AutoInvokerInterface
{
    protected ContainerInterface $container;

    /**
     * @var array<string,string>
     */
    protected array $aliases = [];

    /**
     * @param ContainerInterface $container
     * @param array<string,string> $aliases
     */
    public function __construct(ContainerInterface $container, array $aliases = [])
    {
        $this->container = $container;
        $this->aliases = $aliases;
    }

    public function invoke($function)
    {
        if ($this->isMethod($function)) {
            return $this->invokeMethod(...$function);
        } elseif ($this->isFunction($function)) {
            return $this->invokeFunction($function);
        } else {
            throw $this->notCallableException();
        }
    }

    public function resolve($function): array
    {
        if ($this->isMethod($function)) {
            return $this->resolveMethod(...$function);
        } elseif ($this->isFunction($function)) {
            return $this->resolveFunction($function);
        } else {
            throw $this->notCallableException();
        }
    }

    protected function isMethod($function): bool
    {
        return is_array($function)
            && count($function) === 2
            && array_is_list($function)
            && method_exists(...$function);
    }

    protected function isFunction($function): bool
    {
        return $function instanceof Closure
            || (is_string($function) && is_callable($function));
    }

    protected function notCallableException(): Throwable
    {
        return new InvalidArgumentException("Value provided is not callable.");
    }

    protected function invokeMethod(object $instance, string $method)
    {
        $method = new ReflectionMethod($instance, $method);
        $method->setAccessible(true);

        return $method->invokeArgs($instance, $this->getArgs($method));
    }

    protected function resolveMethod(object $instance, string $method): array
    {
        return $this->getArgs(new ReflectionMethod($instance, $method));
    }

    /**
     * @param Closure|string $function
     */
    protected function invokeFunction($function)
    {
        $function = new ReflectionFunction($function);

        return $function->invokeArgs($this->getArgs($function));
    }

    /**
     * @param Closure|string $function
     */
    protected function resolveFunction($function)
    {
        return $this->getArgs(new ReflectionFunction($function));
    }

    /**
     * @return array<int,object>
     */
    protected function getArgs(ReflectionFunctionAbstract $function): array
    {
        return array_map([$this, 'getMatchingService'], $function->getParameters());
    }

    protected function getMatchingService(ReflectionParameter $param): object
    {
        $type = $param->getClass()->getName();

        return $this->container->get($this->aliases[$type] ?? $type);
    }
}
