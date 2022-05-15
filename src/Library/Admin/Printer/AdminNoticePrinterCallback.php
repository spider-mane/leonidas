<?php

namespace Leonidas\Library\Admin\Printer;

use Leonidas\Contracts\Admin\Component\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticePrinterInterface;
use Leonidas\Library\Admin\Printer\Abstracts\AbstractAdminNoticePrinter;
use Psr\Http\Message\ServerRequestInterface;

class AdminNoticePrinterCallback extends AbstractAdminNoticePrinter implements AdminNoticePrinterInterface
{
    /**
     * @var callable
     */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function print(AdminNoticeInterface $notice, ServerRequestInterface $request): string
    {
        return ($this->callback)($notice, $request);
    }
}
