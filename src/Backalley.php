<?php

namespace Backalley;

use Twig_Function;
use Twig_SimpleFilter;
use Twig_Extension_StringLoader;

use function DeepCopy\deep_copy;


/**
 * @package Backalley-Core
 */
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

        add_action('admin_enqueue_scripts', [Self::class, 'enqueue']);
        add_filter('timber/twig', [Self::class, 'config_twig']);
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
        // $twig->addExtension(new Twig_Extension_StringLoader());

        self::custom_twig_filters($twig);
        self::custom_twig_functions($twig);

        return $twig;
    }

    /**
     * 
     */
    public static function custom_twig_filters($twig)
    {
        $filters = [
            'subjectify_objects' => 'backalley_subjectify_wp_objects',
            'clone_original' => 'DeepCopy\\deep_copy',
            'sort_terms_hierarchicaly' => 'sort_terms_hierarchicaly',
        ];

        foreach ($filters as $filter => $function) {
            $twig->addFilter(new Twig_SimpleFilter($filter, $function));
        }
    }

    /**
     * 
     */
    public static function custom_twig_functions($twig)
    {
        $functions = [
            'submit_button' => 'submit_button',
            'settings_fields' => 'settings_fields',
            'do_settings_sections' => 'do_settings_sections',
            'settings_errors' => 'settings_errors',
        ];

        foreach ($functions as $alias => $function) {
            $twig->addFunction(new Twig_Function($alias, $function));
        }
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
            "Backalley\\WordPress\\AdminPage" => "Backalley_Admin_Page",
        ];

        foreach ($aliases as $class => $alias) {
            class_alias($class, $alias);
        }
    }
}