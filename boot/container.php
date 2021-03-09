<?php

use League\Container\Container;
use Noodlehaus\Config;
use Noodlehaus\ConfigInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use WebTheory\Leonidas\Admin\Loaders\AdminNoticeCollectionLoader;

$container = new Container();

// register config
$container->add(ConfigInterface::class, function () {
    return new Config(realpath('../config'));
})->setAlias('config')->setShared(true);



// register twig environment
$container->add(Environment::class, function () use ($container) {

    $config = $container->get('config')->get('twig');

    $loader = new FilesystemLoader($config['templates']);
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
})->setAlias('twig')->setShared(true);



// register admin loader
$container->add(AdminNoticeInterface::class, function () {

    $loader = new AdminNoticeCollectionLoader('leonidas.adminNotices');
    $loader->hook();

    return $loader;
})->setAlias('notice_loader')->setShared(true);

return $container;
