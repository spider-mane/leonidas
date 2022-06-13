<?php

use League\Container\Container;
use Panamax\Adapters\League\LeagueAdapter;

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);

/**
 *==========================================================================
 * Create Container
 *==========================================================================
 *
 * Leonidas is a container-agnostic framework. You can use any container you
 * want so long as it is an implementation of the psr-11 standard.
 *
 */

$container = new Container();

/**
 *==========================================================================
 * Populate Container
 *==========================================================================
 *
 * If there's anything that you want to add to your container, you can do it
 * from here using its native api.
 *
 */

$container->add('example', stdClass::class);

/**
 *==========================================================================
 * Return Container
 *==========================================================================
 *
 * If your container implementation of choice is not also an implementation of
 * Panamax\Contracts\ServiceProviderInterface, package it in an adapter
 * implementing Panamax\Contracts\ContainerAdapterInterface. The Launcher
 * bootstrapping class will retrieve the container and take care of the heavy
 * lifting.
 *
 */

return new LeagueAdapter($container);
