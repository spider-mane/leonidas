<?php

namespace WebTheory\Leonidas\Library\Admin\Metabox\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class FieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'metabox/components/field.twig';
}
