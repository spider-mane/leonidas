<?php

namespace Leonidas\Library\Admin\Component\TermField;

use Leonidas\Contracts\Admin\Component\TermField\TermFieldInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Abstracts\AbstractAdminField;
use Leonidas\Library\Admin\Component\TermField\View\AddTermFieldView;
use Leonidas\Library\Admin\Component\TermField\View\EditTermFieldView;
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

        return $view; // @phpstan-ignore-line
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
