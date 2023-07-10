<?php

namespace Leonidas\Library\Admin\Printer;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Printer\AdminNoticePrinterInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeferrableAdminNoticePrinter implements AdminNoticePrinterInterface
{
    protected ?AdminNoticePrinterInterface $printer;

    public function __construct(?AdminNoticePrinterInterface $printer = null)
    {
        $this->printer = $printer;
    }

    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string
    {
        return $this->printer
            ? $this->printer->print($notice, $request)
            : $notice->renderComponent($request);
    }
}
