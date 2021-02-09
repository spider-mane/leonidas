<?php

namespace WebTheory\Leonidas\Admin\Traits;

use GuzzleHttp\Psr7\ServerRequest;

trait CannotBeRestrictedTrait
{
    /**
     *
     */
    public function shouldBeRendered(ServerRequest $request): bool
    {
        return true;
    }
}
