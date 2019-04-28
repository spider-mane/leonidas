<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

class Backalley extends \Backalley_Core_Base
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
}