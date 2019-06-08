<?php

use Timber\Timber;

/**
 * @package Backalley-Core
 */

class BackalleyCoreBase
{
    public static $url;
    public static $path;
    public static $base;
    public static $admin_url;
    public static $admin_templates;
    public static $timber_locations;

    public static function load()
    {
        Self::$path = __DIR__;
        Self::$url = plugin_dir_url(__FILE__);
        Self::$base = plugin_basename(__FILE__);

        Self::$admin_url = Self::$url . "public/admin";
        Self::$admin_templates = Self::$path . "/public/admin/templates";

        Self::$timber_locations = [
            Self::$admin_templates,
            Self::$admin_templates . '/macros',
        ];

        Timber::$locations = Self::$timber_locations;
    }
}


#Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require dirname(__FILE__) . '/vendor/autoload.php';
}
