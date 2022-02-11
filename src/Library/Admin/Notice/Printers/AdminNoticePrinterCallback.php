<?php

namespace Leonidas\Library\Admin\Notice\Printers;

use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticePrinterInterface;
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
