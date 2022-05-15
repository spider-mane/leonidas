<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticePrinterInterface
{
    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string;

    public function printSet(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string;
}
