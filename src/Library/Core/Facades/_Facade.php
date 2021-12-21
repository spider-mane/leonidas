<?php

namespace Leonidas\Library\Core\Facades;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use WebTheory\Facade\MockeryMockableFacadeBaseTrait;

abstract class _Facade
{
    use MockeryMockableFacadeBaseTrait;

    /**
     * @var Container
     */
    protected static $container;

    protected function _updateContainer(string $name, object $instance): void
    {
        static::$container->addShared($name, $instance);
    }
}
