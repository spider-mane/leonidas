<?php

/**
 * @package Backalley-Core
 */


// namespace Backalley;

final class BackAlley
{
    public static $path;
    public static $url;
    public static $templates;
    public static $api_keys;
    public static $meta_key_prefix;
    public static $timber_locations;

    public static function init(array $args = [])
    {
        Self::$path = __DIR__;
        Self::$url = plugin_dir_url(__FILE__);
        Self::$templates = Self::$path . DIRECTORY_SEPARATOR . 'views';

        // Self::$p = plugin_dir_path(__FILE__);
        // Self::$plugin_url = plugin_dir_url(__FILE__);
        // Self::$plugin = plugin_basename(__FILE__);

        Self::$api_keys = $args['api_keys'] ?? [];
        Self::$meta_key_prefix = $args['meta_key_prefix'] ?? '';

        Self::$timber_locations = [
            Self::$templates,
            Self::$templates . DIRECTORY_SEPARATOR . 'macros',
        ];
    }
}



#Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

#Controllers
require_once 'includes/enqueue.php';
require_once 'includes/timber-rules.php';

#Functions
require_once 'includes/functions/functions.php';
require_once 'includes/functions/lists.php';

#Classes
require_once "includes/classes/Guctility_Belt.php";

require_once 'includes/classes/Backalley_Post_Type.php';
require_once 'includes/classes/Backalley_Taxonomy.php';
require_once 'includes/classes/Backalley_Meta_Box.php';
require_once 'includes/classes/Backalley_Term_Option.php';
require_once "includes/classes/Backalley_Admin_Settings.php";

require_once "includes/classes/HTML_Element.php";
require_once "includes/classes/HTML_Element2.php";
require_once "includes/classes/Form_Element.php";
require_once "includes/classes/WP_Form_Field.php";
require_once "includes/classes/Checklist_Element.php";

require_once 'includes/classes/Structural_Taxonomy.php';
require_once "includes/classes/Conceptual_Post_Type_Core.php";
require_once "includes/classes/Backalley_Conceptual_Post_Type.php";
