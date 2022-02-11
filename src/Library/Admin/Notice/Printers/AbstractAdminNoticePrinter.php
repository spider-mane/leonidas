<?php

namespace Leonidas\Library\Admin\Notice\Printers;

use Leonidas\Contracts\Admin\Components\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticePrinterInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAdminNoticePrinter implements AdminNoticePrinterInterface
{
    public function printSet(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string
    {
        $output = '';

        foreach ($notices as $notice) {
            $output .= $this->print($notice, $request);
        }

        return $output;
    }
}
