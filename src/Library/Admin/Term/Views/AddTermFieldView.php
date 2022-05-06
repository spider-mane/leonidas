<?php

namespace Leonidas\Library\Admin\Term\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class AddTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected string $template = 'screens/term/components/add-field.twig';
}
