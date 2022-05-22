<?php

namespace Leonidas\Library\Admin\Loader;

use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Printer\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Printer\DeferrableAdminNoticePrinter;
use Psr\Http\Message\ServerRequestInterface;

class AdminNoticeLoader implements AdminNoticeLoaderInterface
{
    protected AdminNoticeRepositoryInterface $repository;

    protected ?AdminNoticePrinterInterface $printer = null;

    public function __construct(AdminNoticeRepositoryInterface $repository, ?AdminNoticePrinterInterface $printer = null)
    {
        $this->repository = $repository;
        $this->printer = $printer;
    }

    public function print(ServerRequestInterface $request): string
    {
        $notices = $this->repository->all()
            ->getForScreen($request->getAttribute('screen'))
            ->getForUser($request->getAttribute('user'))
            ->toArray();

        if (!$notices) {
            return '';
        }

        $printer = new DeferrableAdminNoticePrinter($this->printer);
        $output = '';

        foreach ($notices as $notice) {
            $output .= $printer->print($notice, $request);

            $this->repository->remove($notice->getId());
        }

        $this->repository->persist($request);

        return $output;
    }

    public function printOne(string $notice, ServerRequestInterface $request): string
    {
        $printer = new DeferrableAdminNoticePrinter($this->printer);

        return $printer->print($this->repository->get($notice), $request);
    }
}
