<?php

namespace Leonidas\Library\Admin\Term;

use Leonidas\Contracts\Admin\Components\TermFieldInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\AbstractAdminField;
use Leonidas\Library\Admin\Term\Views\AddTermFieldView;
use Leonidas\Library\Admin\Term\Views\EditTermFieldView;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;
use Psr\Http\Message\ServerRequestInterface;

class TermField extends AbstractAdminField implements TermFieldInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    public const ADD_TERM_SCREEN = 'edit-tags';

    public const EDIT_TERM_SCREEN = 'term';

    public function renderInputField(ServerRequestInterface $request): string
    {
        return $this->renderFormField($request)->toHtml();
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        switch ($request->getAttribute('context')) {

            case static::ADD_TERM_SCREEN:
                $view = $this->getAddTermFieldView();

                break;

            case static::EDIT_TERM_SCREEN:
                $view = $this->getEditTermFieldView();

                break;
        }

        return $view;
    }

    protected function getAddTermFieldView(): ViewInterface
    {
        return new AddTermFieldView();
    }

    protected function getEditTermFieldView(): ViewInterface
    {
        return new EditTermFieldView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'field' => $this->renderFormField($request),
        ];
    }
}
