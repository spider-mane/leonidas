<?php

namespace WebTheory\Leonidas\Admin\Metabox\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class FieldGridView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'metabox/components/field-grid.twig';
}
