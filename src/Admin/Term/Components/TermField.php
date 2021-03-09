<?php

namespace WebTheory\Leonidas\Admin\Term\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractAdminField;
use WebTheory\Leonidas\Contracts\Admin\Components\TermFieldInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Admin\Term\Views\AddTermFieldView;
use WebTheory\Leonidas\Admin\Term\Views\EditTermFieldView;
use WebTheory\Leonidas\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Traits\RendersWithViewTrait;

class TermField extends AbstractAdminField implements TermFieldInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     *
     */
    protected const ADD_TERM_SCREEN = 'edit-tags';

    /**
     *
     */
    protected const EDIT_TERM_SCREEN = 'term';

    /**
     *
     */
    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        switch (get_current_screen()->base) {

            case static::ADD_TERM_SCREEN:
                $view = $this->getAddTermFieldView();
                break;

            case static::EDIT_TERM_SCREEN:
                $view = $this->getEditTermFieldView();
                break;
        }

        return $view;
    }

    /**
     *
     */
    protected function getAddTermFieldView(): ViewInterface
    {
        return new AddTermFieldView();
    }

    /**
     *
     */
    protected function getEditTermFieldView(): ViewInterface
    {
        return new EditTermFieldView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'field' => $this->renderFormField($request)
        ];
    }
}
