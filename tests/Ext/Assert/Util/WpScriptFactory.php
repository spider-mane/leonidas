<?php

namespace Tests\Ext\Assert\Util;

use _WP_Dependency;

class WpScriptFactory
{
    public function createScript(array $data)
    {
        $handle = $data['handle'];
        $src = $data['src'];
        $deps = $data['deps'] ?? [];
        $ver = $data['ver'] ?? false;
        $inFooter = $data['in_footer'] ?? false;
        $args = $data['args'] ?? null;
        $extra = $data['extra'] ?? [];

        $script = new _WP_Dependency($handle, $src, $deps, $ver, $args);

        if ($inFooter) {
            $script->add_data('group', 1);
        }

        foreach ($extra as $key => $value) {
            $script->add_data($key, $value);
        }

        return $script;
    }

    public static function create(array $data)
    {
        return (new static())->createScript($data);
    }
}
