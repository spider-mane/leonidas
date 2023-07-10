<?php

namespace Leonidas\Contracts\Admin\Loader;

use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticeLoaderInterface
{
    public function printAll(ServerRequestInterface $request): string;

    public function printOne(string $notice, ServerRequestInterface $request): string;

    public function printField(string $field, ServerRequestInterface $request): string;
}
