<?php

namespace Leonidas\Library\Admin\Printer;

use Leonidas\Contracts\Admin\Component\TermField\TermFieldInterface;
use Leonidas\Contracts\Admin\Printer\TermFieldPrinterInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\TermField\View\AddTermFieldView;
use Leonidas\Library\Admin\Component\TermField\View\EditTermFieldView;
use Psr\Http\Message\ServerRequestInterface;

class BasicTermFieldPrinter implements TermFieldPrinterInterface
{
    protected const ADD_TERM_SCREEN = 'edit-tags';

    protected const EDIT_TERM_SCREEN = 'term';

    public function print(array $fields, ServerRequestInterface $request): string
    {
        $output = '';

        foreach ($fields as $field) {
            $this->printOne($field, $request);
        }

        return $output;
    }

    public function printOne(TermFieldInterface $field, ServerRequestInterface $request): string
    {
        if (!$field->shouldBeRendered($request)) {
            return '';
        }

        return $this->defineView($request)->render([
            'label' => $field->getLabel(),
            'description' => $field->getDescription(),
            'field' => $field->renderInputField($request),
        ]);
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        switch ($request->getAttribute('context')) {
            case static::ADD_TERM_SCREEN:
                return new AddTermFieldView();

            case static::EDIT_TERM_SCREEN:
                return new EditTermFieldView();
        }
    }
}
