<?php

/**
 * Plugin Name: Leonidas Content Example
 * Description: Example use of content api
 * Text Domain: example-content
 * Domain Path: /lang
 */

call_user_func(function () {
    require __DIR__ . '/boot/init.php';
    Example\Content\Launcher::init(__FILE__);
});
