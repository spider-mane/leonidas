<?php

namespace WebTheory\Leonidas;

use Noodlehaus\Config;
use Pimple\Container as PimpleContainer;
use Pimple\Psr11\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Leonidas\Field as FieldProxy;
use WebTheory\Leonidas\Fields\Field;

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
            throw new \Exception('Do not call ' . __METHOD__ . ' method.');
        }

        static::load();
        static::bootstrap();
        static::hook();
    }

    /**
     *
     */
    protected static function bootstrap()
    {
        $container = new PimpleContainer;

        static::bindConfig($container);
        static::bindTwig($container);
        static::bindField($container);
        static::$container = new Container($container);

        static::initiateProxies();
    }

    /**
     *
     */
    protected static function initiateProxies()
    {
        FieldProxy::objectProxyInit();
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
        wp_enqueue_script('backalley-core-admin-script', static::$adminUrl . '/assets/js/backalley-admin.js', null, time(), true);

        # backalley styles
        wp_enqueue_style('backalley-core-styles', static::$adminUrl . '/assets/css/backalley-admin-styles.css', null, time());
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

            $loader = new FilesystemLoader(static::$adminTemplates);

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
