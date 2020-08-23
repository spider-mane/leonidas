<?php

namespace WebTheory\Leonidas;

use Noodlehaus\Config;
use Pimple\Container as PimpleContainer;
use Pimple\Psr11\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Leonidas\Fields\Field;
use WebTheory\Leonidas\Loaders\AdminNoticeLoader;

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
        static::bindField($container);

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

        // exit(var_dump($lib));

        # wp included libraries
        wp_enqueue_script('jquery');

        # backalley scripts
        wp_enqueue_script('select2--js', $lib . '/select2.full.min.js', null, time(), true);
        wp_enqueue_script('trix--js', $lib . '/trix.js', null, time(), true);
        wp_enqueue_script('saveyour--js', $lib . '/saveyour.js', ['select2--js', 'trix--js'], time(), true);

        wp_enqueue_script('backalley-core-admin-script', static::$assets . '/js/backalley-admin.js', null, time(), true);

        # backalley styles
        wp_enqueue_style('select2--css', $lib . '/select2.min.css', null, time());
        wp_enqueue_style('trix--css', $lib . '/trix.css', null, time());

        wp_enqueue_style('backalley-core-styles', static::$assets . '/css/backalley-admin-styles.css', null, time());
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

    /**
     *
     */
    protected static function bindField(PimpleContainer $container)
    {
        $container['field'] = function ($plugin) {
            return new Field;
        };
    }
}
