<?php

namespace Leonidas\Library\Admin\Printer;

use Leonidas\Contracts\Admin\Component\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticePrinterInterface;
use Leonidas\Library\Admin\Component\Notice\View\StandardAdminNoticeView;
use Leonidas\Library\Admin\Printer\Abstracts\AbstractAdminNoticePrinter;
use Psr\Http\Message\ServerRequestInterface;

class StandardAdminNoticePrinter extends AbstractAdminNoticePrinter implements AdminNoticePrinterInterface
{
    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string
    {
        return (new StandardAdminNoticeView())->render([
            'type' => $notice->getType(),
            'message' => $notice->getMessage(),
            'is_dismissible' => $notice->isDismissible(),
        ]);
    }
}
