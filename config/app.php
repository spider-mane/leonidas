<?php

use Leonidas\Framework\ConfigReflector;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;

return [

    'root' => dirname(__FILE__, 1),

    /**
     * * Extension Modules
     *
     * Modules are the classes that hook into WordPress and initiate desired
     * functionality on specific events. Because all modules are passed your
     * WpExtensionInterface instance, which in turn provides access to your DI
     * container, they can be designed in a way makes them portable and reusable
     * between projects.
     */
    'modules' => [
        Leonidas\Plugin\Modules\RegisterAssets::class,
        Leonidas\Plugin\Modules\ManageComposerDependencies::class,
        Leonidas\Plugin\Modules\Setup::class,
    ],

    /**
     * * Dependency Injection Container
     *
     *
     * * Entries
     *
     * Entries are individual definitions structured in a way that allows you to
     * build your container by iterating over them. Doing this cleanly from this
     * context requires use of a StaticProviderInterface, which is a
     * library-independent service provider which contains the actual
     * instantiation logic as well as a ConfigReflectorInterface instance which
     * allows for providing the StaticProviderInterface a set of simple
     * arguments that may exist in the same or another config repository once
     * needed. Besides "name, provider, and args", the exact key => value
     * structure will depend on your container library of choice.
     *
     *
     * * Providers
     *
     * Some DI containers support "service providers." These are typically self
     * contained classes with all the logic required for inserting an entry into
     * a container according to that container's capabilities. Because all
     * necessary logic is encapsulated within them, library-specific providers
     * are the cleanest solution to building your container.
     */
    'container' => [
        'entries' => [
            [
                'name' => Twig\Environment::class,
                'provider' => \Leonidas\Framework\Providers\TwigProvider::class,
                'args' => new ConfigReflector(function (): array {
                    return $this->get('twig');
                }),
                'alias' => 'twig',
            ],
            [
                'name' => Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface::class,
                'provider' => Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider::class,
                'args' => new ConfigReflector(function (): array {
                    return [
                        'prefix' => $this->get('plugin.prefix.extended')
                    ];
                }),
                'alias' => 'notice_loader',
            ]
        ],

        'providers' => []
    ],

    /**
     * * Extension Bootstrap Assistants
     *
     * Bootstrap assistants are classes you can use to encapsulate your
     * bootstrap requirements. Useful for keeping your main/bootstrap class
     * clean and being able to reuse processes between extensions.
     */
    'bootstrap' => [],
];
