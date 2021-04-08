<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;

// (new Run())->prependHandler(new PrettyPageHandler())->register();

ini_set('display_errors', '1');
ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);

// initiate var dump server
(function () {
    $cloner = new VarCloner();
    $fallbackDumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();
    $dumper = new ServerDumper('tcp://127.0.0.1:9912', $fallbackDumper, [
        'cli' => new CliContextProvider(),
        'source' => new SourceContextProvider(),
    ]);

    VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
        $dumper->dump($cloner->cloneVar($var));
    });
})();

define('LEONIDAS_DEVELOPMENT', 1);
