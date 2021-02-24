<?php

namespace WebTheory\Leonidas\Admin\Term\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class EditTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'screens/term/edit-field.twig';
}
