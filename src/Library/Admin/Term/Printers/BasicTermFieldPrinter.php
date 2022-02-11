<?php

namespace Leonidas\Library\Admin\Term\Printers;

use Leonidas\Contracts\Admin\Components\TermFieldInterface;
use Leonidas\Contracts\Admin\Components\TermFieldPrinterInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Term\Views\AddTermFieldView;
use Leonidas\Library\Admin\Term\Views\EditTermFieldView;
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
                $view = new AddTermFieldView();

                break;

            case static::EDIT_TERM_SCREEN:
                $view = new EditTermFieldView();

                break;
        }

        return $view;
    }
}
