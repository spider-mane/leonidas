<?php

namespace Leonidas\Library\Admin\Loader;

use Leonidas\Contracts\Admin\Component\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Printer\DeferrableAdminNoticePrinter;
use Leonidas\Library\Admin\Repository\AdminNoticeRepository;
use Psr\Http\Message\ServerRequestInterface;

class AdminNoticeLoader implements AdminNoticeLoaderInterface
{
    protected AdminNoticeRepository $repository;

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
