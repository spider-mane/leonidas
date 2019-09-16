<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;

use Backalley\Form\FieldFactory;
use Backalley\Form\FormFieldFactory;
use Backalley\WordPress\Fields\Field;
use Backalley\Wordpress\Fields\Managers\Factory as DataManagerFactory;
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
     * @var FieldFactory
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
        static::initTwig();
        static::hook();
        static::initFieldFactory($options['field'] ?? []);
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
    protected static function initFieldFactory(array $options = [])
    {
        unset($options['controller']);

        static::$fieldFactory = Field::bootstrap($options);
    }

    /**
     *
     */
    public static function createField($args)
    {
        return static::$fieldFactory->create($args);
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

        static::configTwig($twig);

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
    public static function configTwig($twig)
    {
        static::addTwigFilters($twig);
        static::addTwigFunctions($twig);

        return $twig;
    }

    /**
     *
     */
    public static function addTwigFilters($twig)
    {
        $filters = [];

        foreach ($filters as $filter => $function) {
            $twig->addFilter(new TwigFilter($filter, $function));
        }
    }

    /**
     *
     */
    public static function addTwigFunctions($twig)
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
    public static function aliasClasses()
    {
        $aliases = [];

        foreach ($aliases as $alias => $class) {
            class_alias($class, $alias);
        }
    }
}
