<?php

namespace WebTheory\WpCliUtil;

use Symfony\Component\Yaml\Yaml;

class WpCliUtil
{
    public static function getCliCmd(): string
    {
        return getcwd() . '/vendor/bin/wp';
    }

    public static function getCliConfig(): array
    {
        return Yaml::parseFile(getcwd() . '/wp-cli.yml');
    }

    public static function getInstallPath(): string
    {
        $config = static::getCliConfig();

        return $config['path'];
    }
}
