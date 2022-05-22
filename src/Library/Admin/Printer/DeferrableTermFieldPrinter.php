<?php

namespace Leonidas\Library\Admin\Printer;

use Leonidas\Contracts\Admin\Component\TermField\TermFieldInterface;
use Leonidas\Contracts\Admin\Printer\TermFieldPrinterInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeferrableTermFieldPrinter implements TermFieldPrinterInterface
{
    protected ?TermFieldPrinterInterface $printer = null;

    public function __construct(?TermFieldPrinterInterface $printer = null)
    {
        $this->printer = $printer;
    }

    public function print(array $fields, ServerRequestInterface $request): string
    {
        return $this->printer
            ? $this->printer->print($fields, $request)
            : $this->printFields($fields, $request);
    }

    public function printOne(TermFieldInterface $field, ServerRequestInterface $request): string
    {
        return $this->printer
            ? $this->printer->printOne($field, $request)
            : $field->renderComponent($request);
    }

    /**
     * @param TermFieldInterface[] $fields
     */
    protected function printFields(array $fields, ServerRequestInterface $request): string
    {
        $output = '';

        foreach ($fields as $fields) {
            $output .= $fields->shouldBeRendered($request) ? $fields->renderComponent($request) : '';
        }

        return $output;
    }
}
