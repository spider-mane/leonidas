<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticeLoaderInterface
{
    public function print(ServerRequestInterface $request): string;

    public function printOne(string $notice, ServerRequestInterface $request): string;
}
