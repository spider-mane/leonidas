<?php

namespace WebTheory\Leonidas\Library\Admin\Term\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class AddTermFieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'screens/term/components/add-field.twig';
}
