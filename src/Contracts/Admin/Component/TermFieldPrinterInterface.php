<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface TermFieldPrinterInterface
{
    /**
     * @param TermFieldInterface[] $fields
     */
    public function print(array $fields, ServerRequestInterface $request): string;

    public function printOne(TermFieldInterface $field, ServerRequestInterface $request): string;
}
