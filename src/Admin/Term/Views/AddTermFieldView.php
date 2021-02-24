<?php

namespace WebTheory\Leonidas\Admin\Term\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class AddTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'screens/term/add-field.twig';
}
