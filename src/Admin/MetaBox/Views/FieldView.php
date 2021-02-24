<?php

namespace WebTheory\Leonidas\Admin\Metabox\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class FieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'metabox/components/field.twig';
}
