<?php

namespace WebTheory\WpCliUtil;

class WpCliRunner
{
    public static function installWordPress(array $args = []): void
    {
        $wp = WpCliUtil::getCliCmd();
        $clean = "$wp db clean --yes";
        $install = "$wp core install";

        if (static::wpIsInstalled()) {
            system("$clean && $install");
        } else {
            system($install);
        }
    }

    public static function wpIsInstalled(): bool
    {
        $wp = WpCliUtil::getCliCmd();
        $map = [0 => true, 1 => false];

        system("$wp core is-installed", $status);

        return $map[$status];
    }
}
