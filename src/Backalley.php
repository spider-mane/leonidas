<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

class Backalley extends \BackalleyCoreBase
{
    public static $api_keys;
    public static $meta_key_prefix;

    /**
     * 
     */
    public static function init(array $args = [])
    {
        Self::load();

        Self::$api_keys = $args['api_keys'] ?? [];
        Self::$meta_key_prefix = $args['meta_key_prefix'] ?? '';

        Self::alias_classes();

        add_action('admin_enqueue_scripts', [__class__, 'enqueue']);
        add_filter('timber/twig', [__class__, 'config_twig']);
    }

    /**
     * 
     */
    public static function enqueue()
    {
        # wp included libraries
        wp_enqueue_script('jquery');

        # backalley scripts
        wp_enqueue_script('backalley-core-admin-script', Self::$admin_url . '/assets/js/backalley-admin.js', null, time(), true);
    
        # backalley styles
        wp_enqueue_style('backalley-core-styles', Self::$admin_url . '/assets/css/backalley-admin-styles.css', null, time());
    }

    /**
     * 
     */
    public static function config_twig($twig)
    {
        return $twig;
    }

    /**
     * 
     */
    public static function alias_classes()
    {
        $aliases = [
            "Respect\\Validation\\Validator" => "Backalley\\Validator",
            "Backalley\\WordPress\\PostType" => "Backalley_Post_Type",
            "Backalley\\WordPress\\Taxonomy" => "Backalley_Taxonomy",
            "Backalley\\WordPress\\MetaBox" => "Backalley_Meta_Box",
        ];

        foreach ($aliases as $class => $alias) {
            class_alias($class, $alias);
        }
    }
}