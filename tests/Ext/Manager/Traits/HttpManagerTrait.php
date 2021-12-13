<?php

namespace Tests\Ext\Manager\Traits;

use Tests\Ext\WpLoader;

trait HttpManagerTrait
{
    public static function resetHttpGlobals(array $vars = [])
    {
        static::resetServer($vars['server'] ?? []);
        static::resetRequest($vars['request'] ?? []);
        static::resetGet($vars['get'] ?? []);
        static::resetPost($vars['post'] ?? []);
    }

    public static function resetServer(array $vars = []): void
    {
        $config = WpLoader::getCliConfig();
        $url = $config['core install']['url'];

        $domain = preg_replace('/(^\w+:|^)\/\//', '', $url);

        $_SERVER['HTTP_HOST'] = $domain;
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '';
        $_SERVER['SERVER_NAME'] = $domain;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

        unset($_SERVER['HTTP_REFERER'], $_SERVER['HTTPS']);


        $_SERVER = array_merge($_SERVER, static::ensureProperCase($vars));
    }

    public static function resetRequest(array $vars = []): void
    {
        $_REQUEST = [];

        $_REQUEST = array_merge($_REQUEST, static::ensureProperCase($vars));
    }

    public static function resetGet(array $vars = []): void
    {
        $_GET = [];

        $_GET = array_merge($_GET, static::ensureProperCase($vars));
    }

    public static function resetPost(array $vars = []): void
    {
        $_POST = [];

        $_POST = array_merge($_POST, static::ensureProperCase($vars));
    }

    protected static function ensureProperCase(array $vars)
    {
        return array_change_key_case($vars, CASE_UPPER);
    }
}
