<?php

/**
 * This file is part of the Backalley package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   Backalley
 * @license   GNU GPL
 * @copyright Copyright (C) WebTheory Studio, All rights reserved.
 * @link      https://github.com/spider-mane/backalley
 * @author    Chris Williams <christwilhelm84@gmail.com>
 */

if (!class_exists('BackalleyCoreBase')) {

    /**
     *
     */
    class BackalleyCoreBase
    {
        public static $url;
        public static $path;
        public static $base;
        public static $admin_url;
        public static $admin_templates;

        public static function load()
        {
            Self::$path = __DIR__;
            Self::$url = plugin_dir_url(__FILE__);
            Self::$base = plugin_basename(__FILE__);

            Self::$admin_url = Self::$url . "public/admin";
            Self::$admin_templates = Self::$path . "/public/admin/templates";
        }
    }
}

#Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require dirname(__FILE__) . '/vendor/autoload.php';
}
