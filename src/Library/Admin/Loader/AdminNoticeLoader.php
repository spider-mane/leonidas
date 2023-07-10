<?php

namespace Leonidas\Library\Admin\Loader;

use Leonidas\Contracts\Admin\Component\Notice\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Printer\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Printer\DeferrableAdminNoticePrinter;
use Psr\Http\Message\ServerRequestInterface;

class AdminNoticeLoader implements AdminNoticeLoaderInterface
{
    protected AdminNoticeRepositoryInterface $repository;

    protected ?AdminNoticePrinterInterface $printer;

    public function __construct(AdminNoticeRepositoryInterface $repository, ?AdminNoticePrinterInterface $printer = null)
    {
        $this->repository = $repository;
        $this->printer = new DeferrableAdminNoticePrinter($printer);
    }

    public function printAll(ServerRequestInterface $request): string
    {
        return $this->printNotices($this->repository->all(), $request);
    }

    public function printOne(string $notice, ServerRequestInterface $request): string
    {
        return $this->printer->print(
            $this->repository->get($notice),
            $request
        );
    }

    public function printField(string $field, ServerRequestInterface $request): string
    {
        return $this->printNotices(
            $this->repository->forField($field),
            $request
        );
    }

    protected function printNotices(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string
    {
        $output = '';

        if (!$notices->hasItems()) {
            return $output;
        }

        foreach ($notices as $notice) {
            if ($notice->shouldBeRendered($request)) {
                $output .= $this->printer->print($notice, $request);
            }
        }

        return $output;
    }
}
