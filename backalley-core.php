<?php

/**
 * @package Backalley-Core
 */

class Backalley_Base
{
    public static $path;
    public static $url;
    public static $admin_url;
    public static $admin_templates;
    public static $timber_locations;

    public static function load()
    {
        Self::$path = __DIR__;
        Self::$url = plugin_dir_url(__FILE__);

        Self::$admin_url = Self::$url . "public/admin";
        Self::$admin_templates = Self::$path . "/public/admin/templates";

        // Self::$p = plugin_dir_path(__FILE__);
        // Self::$plugin_url = plugin_dir_url(__FILE__);
        // Self::$plugin = plugin_basename(__FILE__);

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
