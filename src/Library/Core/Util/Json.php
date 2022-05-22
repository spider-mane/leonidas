<?php

namespace Leonidas\Library\Core\Util;

class Json
{
    public static function encodeSafe($input, bool $slashes = true): string
    {
        $flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $input = json_encode($input, $flags);

        return $slashes ? wp_slash($input) : $input;
    }

    public static function send($response, $status, $options): void
    {
        wp_send_json($response, $status, $options);
    }
}
