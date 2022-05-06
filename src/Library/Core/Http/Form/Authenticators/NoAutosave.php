<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class NoAutosave implements ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return !(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE);
    }
}
