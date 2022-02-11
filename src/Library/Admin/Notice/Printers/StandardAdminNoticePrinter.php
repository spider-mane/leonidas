<?php

namespace Leonidas\Library\Admin\Notice\Printers;

use Leonidas\Contracts\Admin\Components\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticePrinterInterface;
use Leonidas\Library\Admin\Notice\Views\StandardAdminNoticeView;
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
