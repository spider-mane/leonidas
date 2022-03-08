<?php

namespace Leonidas\Library\Admin\Term\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class EditTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected $template = 'screens/term/components/edit-field.twig';
}
