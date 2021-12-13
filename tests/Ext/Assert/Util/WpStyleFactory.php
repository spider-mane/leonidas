<?php

namespace Tests\Ext\Assert\Util;

use _WP_Dependency;

class WpStyleFactory
{
    public function createStyle(array $data)
    {
        $handle = $data['handle'];
        $src = $data['src'];
        $deps = $data['deps'] ?? [];
        $ver = $data['ver'] ?? false;
        $media = $data['media'] ?? 'all';
        $args = $data['args'] ?? null;
        $extra = $data['extra'] ?? [];

        $style = new _WP_Dependency($handle, $src, $deps, $ver, $media);

        foreach ($extra as $key => $value) {
            $style->add_data($key, $value);
        }

        return $style;
    }

    public static function create(array $data)
    {
        return (new static())->createStyle($data);
    }
}
