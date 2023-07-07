<?php

/**
 * Plugin Name: Leonidas Example Plugin
 * Description: Example plugin for runtime testing Leonidas features
 * Text Domain: example-plugin
 * Domain Path: /lang
 */

call_user_func(function () {
    require __DIR__ . '/boot/init.php';
    Example\Plugin\Launcher::init(__FILE__);
});
