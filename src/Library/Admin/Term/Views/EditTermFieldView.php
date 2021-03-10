<?php

namespace WebTheory\Leonidas\Library\Admin\Term\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class EditTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'screens/term/components/edit-field.twig';
}
