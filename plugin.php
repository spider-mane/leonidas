<?php

/**
 * This file is part of the WebTheory Leonidas package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Leonidas
 * @license GPL-3.0-or-later
 * @copyright Copyright (C) Chris Williams, All rights reserved.
 * @link https://github.com/spider-mane/leonidas
 * @author Chris Williams <spider.mane.web@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name: Leonidas
 * Description: Plugin framework with enhanced api library.
 */

use WebTheory\Leonidas\Plugin\Leonidas;

// composer autoload
if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    require $autoload;
}

// file required for development purposes
if (file_exists($dev = __DIR__ . '/dev.php')) {
    require $dev;
}

// bootstrap
Leonidas::init([
    'path' => realpath(__DIR__),
    'base' => plugin_basename(__FILE__),
    'uri' => plugin_dir_url(__FILE__),
]);





/**
 * Below is an example of bootstrapping an extension from the extension base
 * file instead of using a bootstrap class.
 *
 * @todo Relocate this to a markdown file
 */

// use Psr\Container\ContainerInterface;
// use WebTheory\Leonidas\Framework\Enum\ExtensionType;
// use WebTheory\Leonidas\Framework\ModuleInitializer;
// use WebTheory\Leonidas\Framework\WpExtension;

// /** @var ContainerInterface $container */
// $container = require 'boot/container.php';

// $extension = WpExtension::create([
//     'name' => 'Leonidas',
//     'prefix' => 'leon',
//     'path' => __DIR__,
//     'base' => plugin_basename(__FILE__),
//     'url' => plugin_dir_url(__FILE__),
//     'assets' => '/assets/dist',
//     'dev' => 'LEONIDAS_IN_DEVELOPMENT',
//     'type' => new ExtensionType('plugin'),
//     'container' => $container
// ]);

// $plugin = new ModuleInitializer($extension, $extension->config('app.modules'));

// $plugin->init();
