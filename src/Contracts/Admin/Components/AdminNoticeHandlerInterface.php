<?php

namespace Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticeHandlerInterface
{
    public function print(ServerRequestInterface $request): string;

    public function printOne(string $notice, ServerRequestInterface $request): string;
}
