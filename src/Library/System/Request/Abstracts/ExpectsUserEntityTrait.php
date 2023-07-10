<?php

namespace Leonidas\Library\System\Request\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use WP_User;

trait ExpectsUserEntityTrait
{
    protected function getUser(ServerRequestInterface $request): ?WP_User
    {
        return $request->getAttribute('user');
    }

    protected function getUserId(ServerRequestInterface $request): ?int
    {
        return ($user = $this->getUser($request)) ? $user->ID : null;
    }
}
