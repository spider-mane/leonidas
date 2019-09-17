<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;

use Backalley\WordPress\Fields\Field;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Backalley extends \BackalleyCoreBase
{
    /**
     * @var Environment
     */
    protected static $twigInstance;

    /**
     * @var Field
     */
    protected static $fieldFactory;

    public const BASEDIR = '../../';
    public const PLUGINNAME = 'backalley';

    /**
     *
     */
    public static function init(array $options = null)
    {
        static::load();
        static::hook();
        static::initTwig();
        static::initFieldFactory();
    }

    /**
     *
     */
    protected static function hook()
    {
        add_action('admin_enqueue_scripts', [static::class, 'enqueue']);
    }

    /**
     *
     */
    public static function enqueue()
    {
        # wp included libraries
        wp_enqueue_script('jquery');

        # backalley scripts
        wp_enqueue_script('backalley-core-admin-script', static::$admin_url . '/assets/js/backalley-admin.js', null, time(), true);

        # backalley styles
        wp_enqueue_style('backalley-core-styles', static::$admin_url . '/assets/css/backalley-admin-styles.css', null, time());
    }

    /**
     *
     */
    protected static function initFieldFactory()
    {
        static::$fieldFactory = new Field;
    }

    /**
     *
     */
    public static function createField(array $args)
    {
        return static::$fieldFactory->create($args);
    }

    /**
     *
     */
    protected static function initTwig()
    {
        $options = [
            'autoescape' => false,
        ];

        $loader = new FilesystemLoader(static::$admin_templates);

        $twig = new Environment($loader, $options);

        static::configTwig($twig);

        static::$twigInstance = $twig;
    }

    /**
     *
     */
    public static function renderTemplate(string $template, array $context)
    {
        return static::$twigInstance->render("{$template}.twig", $context);
    }

    /**
     *
     */
    protected static function configTwig($twig)
    {
        static::addTwigFilters($twig);
        static::addTwigFunctions($twig);

        return $twig;
    }

    /**
     *
     */
    protected static function addTwigFilters($twig)
    {
        $filters = [];

        foreach ($filters as $filter => $function) {
            $twig->addFilter(new TwigFilter($filter, $function));
        }
    }

    /**
     *
     */
    protected static function addTwigFunctions($twig)
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
    protected static function aliasClasses()
    {
        $aliases = [];

        foreach ($aliases as $alias => $class) {
            class_alias($class, $alias);
        }
    }
}
