<?php

namespace Leonidas\Library\Core\Util;

class Json
{
    public static function encodeSafe($input, bool $slashes = true)
    {
        $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($slashes) {
            $input = wp_slash($input);
        }

        return $input;
    }

    public static function return($status)
    {
        $return = [
            'status' => $status,
        ];

        wp_send_json($return);

        wp_die();
    }
}
