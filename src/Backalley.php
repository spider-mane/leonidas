<?php

/**
 * @package Backalley-Core
 */

namespace Backalley;

class Backalley extends Base
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
    public function enqueue()
    {
        # wp included libraries
        wp_enqueue_script('jquery');

        # backalley scripts
        wp_enqueue_script('backalley-core-admin-script', BackAlley::$url . 'assets/js/backalley-admin.js', null, time(), true);
    
        # backalley styles
        wp_enqueue_style('backalley-core-styles', BackAlley::$url . 'assets/css/backalley-admin-styles.css', null, time());
    }

    /**
     * 
     */
    public function config_twig($twig)
    {
        return $twig;
    }
}