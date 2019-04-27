<?php

/**
 * @package Backalley-Core
 */

class Base
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


#Functions
require_once 'includes/functions/functions.php';
require_once 'includes/functions/lists.php';

#Classes
// require_once "includes/classes/Guctility_Belt.php";

// require_once 'includes/classes/Backalley_Post_Type.php';
// require_once 'includes/classes/Backalley_Taxonomy.php';
// require_once 'includes/classes/Backalley_Meta_Box.php';
// require_once 'includes/classes/Backalley_Term_Option.php';
// require_once "includes/classes/Backalley_Admin_Settings.php";

// require_once "includes/classes/HTML_Element.php";
// require_once "includes/classes/HTML_Element2.php";
// require_once "includes/classes/Form_Element.php";
// require_once "includes/classes/WP_Form_Field.php";
// require_once "includes/classes/Checklist_Element.php";

// require_once 'includes/classes/Structural_Taxonomy.php';
// require_once "includes/classes/Conceptual_Post_Type_Core.php";
// require_once "includes/classes/Backalley_Conceptual_Post_Type.php";
