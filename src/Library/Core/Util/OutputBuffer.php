<?php

namespace Leonidas\Library\Core\Util;

class OutputBuffer
{
    public static function wrapFunctionCall(callable $function, ...$args): string
    {
        ob_start();

        call_user_func_array($function, $args);

        return ob_get_clean();
    }
}
