<?php

namespace Leonidas\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ConstrainerInterface
{
    /**
     *
     */
    public function requestMeetsCriteria(ServerRequestInterface $request): bool;
}
