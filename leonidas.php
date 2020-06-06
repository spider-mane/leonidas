<?php

/**
 * This file is part of the WebTheory Leonidas package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Leonidas
 * @license GPL-3.0-or-later
 * @copyright Copyright (C) Chris Williams, All rights reserved.
 * @link https://github.com/spider-mane/lenidas
 * @author Chris Williams <spider.mane.web@gmail.com>
 *
 * @wordpress-plugin
 * Plugin Name: Leonidas
 * Description: Description of the plugin.
 */

use WebTheory\Leonidas\Leonidas;
use WebTheory\Leonidas\WpExtension;

# composer autoload
if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    require $autoload;
}

// Leonidas::init(WpExtension::create([
//     'name' => plugin_basename(__FILE__),
//     'path' => __DIR__,
//     'url' => plugin_dir_url(__FILE__),
//     'prefix' => 'leon',
//     'type' => 'plugin'
// ]));

# define filesystem variables in base class
if (!class_exists('WebTheoryLeonidasPluginBaseClass')) {

    class WebTheoryLeonidasPluginBaseClass
    {
        protected static $url;
        protected static $path;
        protected static $base;
        protected static $assets;
        protected static $templates;

        protected static $loaded = false;

        protected static function load()
        {
            static::$path = __DIR__;
            static::$url = plugin_dir_url(__FILE__);
            static::$base = plugin_basename(__FILE__);

            static::$assets = static::$url . "/assets/dist";
            static::$templates = static::$path . "/templates";

            static::$loaded = true;
        }

        public static function get(string $property)
        {
            return static::${$property};
        }

        public static function isLoaded()
        {
            return static::$loaded;
        }
    }
}

# bootstrap plugin
if (!Leonidas::isLoaded()) {
    Leonidas::init();
}
