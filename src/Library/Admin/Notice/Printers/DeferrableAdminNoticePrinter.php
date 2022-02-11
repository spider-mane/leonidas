<?php

namespace Library\Admin\Notice\Printers;

use Leonidas\Contracts\Admin\Components\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticePrinterInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeferrableAdminNoticePrinter implements AdminNoticePrinterInterface
{
    protected ?AdminNoticePrinterInterface $printer;

    public function __construct(?AdminNoticePrinterInterface $printer = null)
    {
        $printer && $this->printer = $printer;
    }

    public function printSet(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string
    {
        return $this->printer
            ? $this->printer->printSet($notices, $request)
            : $this->printNotices($notices, $request);
    }

    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string
    {
        return $this->printer
            ? $this->printer->print($notice, $request)
            : $this->printNotice($notice, $request);
    }

    protected function printNotice(AdminNoticeInterface $notice, ServerRequestInterface $request): string
    {
        return $notice->shouldBeRendered($request) ? $notice->renderComponent($request) : '';
    }

    protected function printNotices(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string
    {
        $output = '';

        foreach ($notices->toArray() as $notice) {
            $output .= $notice->renderComponent($request);
        }

        return $output;
    }
}
