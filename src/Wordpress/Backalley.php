<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;

use Twig\TwigFilter;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

class Backalley extends \BackalleyCoreBase
{
    // public static $url;
    // public static $path;
    // public static $base;
    // public static $admin_url;
    // public static $admin_templates;
    // public static $timber_locations;

    /**
     * @var Twig\Environment
     */
    protected static $twigInstance;

    public const BASEDIR = '../../';
    public const PLUGINNAME = 'backalley';

    /**
     *
     */
    public static function init(array $options = [])
    {
        Self::load();

        static::initTwig();

        add_action('admin_enqueue_scripts', [Self::class, 'enqueue']);
    }

    // /**
    //  *
    //  */
    // public static function load()
    // {
    //     $file = static::BASEDIR . static::PLUGINNAME . '.php';

    //     Self::$path = dirname(static::BASEDIR);
    //     Self::$url = plugin_dir_url($file);
    //     Self::$base = plugin_basename($file);

    //     Self::$admin_url = Self::$url . "public/admin";
    //     Self::$admin_templates = Self::$path . "/public/admin/templates";

    //     Self::$timber_locations = [
    //         Self::$admin_templates,
    //         Self::$admin_templates . '/macros',
    //     ];

    //     Timber::$locations = Self::$timber_locations;
    // }

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
    public static function initTwig()
    {
        $options = [
            'autoescape' => false,
        ];

        $loader = new FilesystemLoader(static::$admin_templates);

        $twig = new Environment($loader, $options);

        self::config_twig($twig);

        static::$twigInstance = $twig;
    }

    /**
     *
     */
    public static function renderTemplate($template, $context)
    {
        return static::$twigInstance->render("{$template}.twig", $context);
    }

    /**
     *
     */
    public static function config_twig($twig)
    {
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
            $twig->addFilter(new TwigFilter($filter, $function));
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
            $twig->addFunction(new TwigFunction($alias, $function));
        }
    }

    /**
     *
     */
    public static function alias_classes()
    {
        $aliases = [];

        foreach ($aliases as $class => $alias) {
            class_alias($class, $alias);
        }
    }
}
