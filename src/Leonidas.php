<?php

namespace WebTheory\Leonidas;

use Noodlehaus\Config;
use Pimple\Container as PimpleContainer;
use Pimple\Psr11\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Leonidas\Admin\Loaders\AdminNoticeLoader;

class Leonidas extends \WebTheoryLeonidasPluginBaseClass
{
    /**
     * @var Container
     */
    protected static $container;

    /**
     *
     */
    public static function init()
    {
        if (static::isLoaded()) {
            $method = __METHOD__;
            $message = "Leonidas should only be initiated internally. If you're seeing this Exception it is because the
            user, a plugin, or a theme has made an illegitimate call to {$method}";

            throw new \Exception($message);
        }

        require dirname(__FILE__) . '/Helpers/functions.php';

        static::load();
        static::bootstrapContainer();
        static::initiateLoaders();
        static::hook();

        do_action('leonidas.init');
    }

    /**
     *
     */
    protected static function bootstrapContainer()
    {
        $container = new PimpleContainer;

        static::bindConfig($container);
        static::bindTwig($container);

        static::$container = new Container($container);
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
    protected static function initiateLoaders()
    {
        AdminNoticeLoader::hook();
    }

    /**
     *
     */
    public static function enqueue()
    {
        $lib = static::$assets . "/lib";
        $saveyourDeps = ['select2', 'trix'];

        // wp included libraries
        wp_enqueue_script('jquery');

        // lib styles
        wp_enqueue_style('select2', $lib . '/select2.min.css', null);
        wp_enqueue_style('trix', $lib . '/trix.css', null);

        // lib scripts
        wp_enqueue_script('select2', $lib . '/select2.full.min.js', null, time(), true);
        wp_enqueue_script('trix', $lib . '/trix.js', null, time(), true);
        wp_enqueue_script('saveyour--js', $lib . '/saveyour.js', $saveyourDeps, time(), true);

        // plugin assets
        wp_enqueue_style('leonidas', static::$assets . '/css/backalley-admin-styles.css', null, time());
        wp_enqueue_script('leonidas', static::$assets . '/js/backalley-admin.js', null, time(), true);
    }

    /**
     *
     */
    protected static function bindConfig(PimpleContainer $container)
    {
        $container['config'] = function ($plugin) {
            return new Config(static::$path . '/config/leonidas.php');
        };
    }

    /**
     *
     */
    protected static function bindTwig(PimpleContainer $container)
    {
        $container['twig'] = function ($plugin) {

            $config = $plugin['config']->get('twig');

            $loader = new FilesystemLoader(static::$templates);

            $twig = new Environment($loader, $config['options']);

            // define filters
            foreach ($config['filters'] as $filter => $function) {
                $twig->addFilter(new TwigFilter($filter, $function));
            }

            // define functions
            foreach ($config['functions'] as $alias => $function) {
                $twig->addFunction(new TwigFunction($alias, $function));
            }

            return $twig;
        };
    }
}
