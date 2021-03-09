<?php

namespace WebTheory\Leonidas\Contracts\Auth;

use Psr\Http\Message\ServerRequestInterface;

interface ConstrainerInterface
{
    /**
     *
     */
    public function requestMeetsCriteria(ServerRequestInterface $request): bool;
}
