<?php

/**
 * @package Backalley-Core
 */

class Backalley_Core_Base
{
    public static $url;
    public static $path;
    public static $base;
    public static $admin_url;
    public static $admin_templates;
    public static $timber_locations;

    public static function load()
    {
        Self::$base = plugin_basename(__FILE__);
        Self::$path = __DIR__;
        Self::$url = plugin_dir_url(__FILE__);

        Self::$admin_url = Self::$url . "public/admin";
        Self::$admin_templates = Self::$path . "/public/admin/templates";

        Self::$timber_locations = [
            Self::$admin_templates,
            Self::$admin_templates . '/macros',
        ];
    }
}


#Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}
