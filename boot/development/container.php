<?php

use League\Container\Container;
use Panamax\Contracts\ContainerAdapterInterface;

/**
 * @var string $root
 * @var string $url
 */

/** @var ContainerAdapterInterface $adapter */
$adapter = require dirname(__DIR__) . '/container.php';

/** @var Container $container */
$container = $adapter->getAdaptedContainer();

return $adapter;
