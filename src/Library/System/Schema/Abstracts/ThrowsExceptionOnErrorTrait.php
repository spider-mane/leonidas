<?php

namespace Leonidas\Library\System\Schema\Abstracts;

use Exception;

trait ThrowsExceptionOnErrorTrait
{
    protected function throwExceptionIfError($result, string $exception = Exception::class): void
    {
        if (is_wp_error($result)) {
            throw new $exception($result->get_error_message());
        }
    }
}
