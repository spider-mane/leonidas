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
use UnexpectedValueException;

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
        return match ($value = $request->getAttribute('context')) {
            static::ADD_TERM_SCREEN => $this->getAddTermFieldView(),
            static::EDIT_TERM_SCREEN => $this->getEditTermFieldView(),
            default => throw new UnexpectedValueException(
                "Unexpected value \"{$value}\" provided as context."
            )
        };
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
