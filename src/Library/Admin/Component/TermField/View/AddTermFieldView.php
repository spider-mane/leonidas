<?php

namespace Leonidas\Library\Admin\Component\TermField\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\Abstracts\AbstractTwigView;

class AddTermFieldView extends AbstractTwigView implements ViewInterface
{
    protected string $view = 'screens.term.components.add-field';
}
