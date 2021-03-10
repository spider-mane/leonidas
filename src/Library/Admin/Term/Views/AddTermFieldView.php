<?php

namespace Leonidas\Library\Admin\Term\Views;

use Leonidas\Contracts\Admin\Components\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class AddTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'screens/term/components/add-field.twig';
}
