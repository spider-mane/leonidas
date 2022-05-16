<?php

namespace Leonidas\Contracts\Admin\Printer;

use Leonidas\Contracts\Admin\Component\TermField\TermFieldInterface;
use Psr\Http\Message\ServerRequestInterface;

interface TermFieldPrinterInterface
{
    /**
     * @param TermFieldInterface[] $fields
     */
    public function print(array $fields, ServerRequestInterface $request): string;

    public function printOne(TermFieldInterface $field, ServerRequestInterface $request): string;
}
