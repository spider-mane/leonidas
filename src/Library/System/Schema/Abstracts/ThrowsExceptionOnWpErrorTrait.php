<?php

namespace Leonidas\Library\System\Schema\Abstracts;

use Exception;
use WP_Error;

trait ThrowsExceptionOnWpErrorTrait
{
    protected function throwExceptionIfWpError($result, string $exception = Exception::class): void
    {
        if ($result instanceof WP_Error) {
            throw new $exception($result->get_error_message());
        }
    }
}
