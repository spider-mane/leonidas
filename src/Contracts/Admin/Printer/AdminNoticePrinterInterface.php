<?php

namespace Leonidas\Contracts\Admin\Printer;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AdminNoticePrinterInterface
{
    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string;
}
