<?php

namespace Leonidas\Library\System\Schema\Abstracts;

use Exception;
use Throwable;
use WP_Error;

trait ThrowsExceptionOnWpErrorTrait
{
    /**
     * @throws Throwable
     */
    protected function throwExceptionIfWpError($result, string $exception = Exception::class): void
    {
        if ($result instanceof WP_Error) {
            throw new $exception($result->get_error_message());
        }
    }
}
