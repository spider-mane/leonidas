<?php

namespace Leonidas\Library;

function ob_wrap_function(callable $function, ...$args): string
{
    ob_start();

    call_user_func_array($function, $args);

    return ob_get_clean();
}
