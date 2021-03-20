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
 * Description: Theme and plugin framework with enhanced WordPress abstraction library.
 */

use Leonidas\Plugin\Leonidas;

if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    require $autoload;
}

Leonidas::init([
    'path' => __DIR__,
    'base' => plugin_basename(__DIR__),
    'uri' => plugin_dir_url(__DIR__),
]);
