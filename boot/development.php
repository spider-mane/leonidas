<?php

use Leonidas\Library\Core\Config\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

defined('ABSPATH') || exit;

$root = dirname(__DIR__, 1);
$errorLog = "$root/wordpress.log";

/**
 * Begin output buffering here to ensure proper display of errors and var dumps
 */
ob_start();

/**
 * Establish that plugin is in a development environment via constant
 */
define('LEONIDAS_DEVELOPMENT', true);

/**
 * Set WordPress debug settings
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_MODE_CHECKS', false); // one can dream. 😔
define('WP_DEBUG_LOG', $errorLog);
define('SCRIPT_DEBUG', true);
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
define('SAVEQUERIES', true);

/**
 * Set development related ini directives
 *
 * @link https://www.php.net/manual/en/errorfunc.configuration.php
 * @link https://xdebug.org/docs/all_settings
 */
ini_set('display_errors', true);
ini_set('error_reporting ', E_ALL);
ini_set('log_errors', true);
ini_set('error_log', $errorLog);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
ini_set('xdebug.var_display_max_depth', 10);

/**
 * Initiate vendor development dependencies. Encapsulate each in an anonymous
 * function to keep variables scoped
 */
require_once "$root/vendor/autoload.php";

$config = new Config("$root/config");

/**
 * Monolog logging
 *
 * @link https://seldaek.github.io/monolog/
 */
$logger = call_user_func(function (string $errorLog): LoggerInterface {
    $streamHandler = new StreamHandler($errorLog, Logger::DEBUG);
    $streamFormatter = new LineFormatter(null, null, true, true);
    $logger = new Logger('stderr');

    $streamHandler->setFormatter($streamFormatter);
    $logger->pushHandler($streamHandler);

    return $logger;
}, $errorLog);

/**
 * Whoops error handling
 *
 * @link http://filp.github.io/whoops/
 */
call_user_func(function (LoggerInterface $logger) {
    $htmlHandler = new PrettyPageHandler();
    $logHandler = new PlainTextHandler($logger);
    $run = new Run();

    $logHandler->setDumper('dump')->loggerOnly(true);
    $run->pushHandler($htmlHandler)
        ->pushHandler($logHandler)
        ->register();
}, $logger);

/**
 * Symfony Dump Server
 *
 * @link https://symfony.com/doc/current/components/var_dumper.html#the-dump-server
 */
call_user_func(function () {
    $cloner = new VarCloner();
    $fallbackDumper = in_array(PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();
    $dumper = new ServerDumper('tcp://127.0.0.1:9912', $fallbackDumper, [
        'cli' => new CliContextProvider(),
        'source' => new SourceContextProvider(),
    ]);

    VarDumper::setHandler(function ($var) use ($dumper, $cloner) {
        $dumper->dump($cloner->cloneVar($var));
    });
});

/**
 * Disable WordPress setting ini error directives for more fine tuned control
 *
 * @see wp_debug_mode() in wp-includes/load.php
 * @link https://developer.wordpress.org/reference/hooks/enable_wp_debug_mode_checks/
 */
call_user_func(function () {
    $GLOBALS['wp_filter'] = [
        'enable_wp_debug_mode_checks' => [
            10 => [
                [
                    'accepted_args' => 0,
                    'function' => function () {
                        return false; // this is where it happens 😒
                    },
                ],
            ],
        ],
    ];
});
