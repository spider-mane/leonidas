<?php

namespace WebTheory\Leonidas\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ComponentConstrainerInterface
{
    /**
     *
     */
    public function screenMeetsCriteria(ServerRequestInterface $request): bool;
}
