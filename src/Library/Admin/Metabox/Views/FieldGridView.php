<?php

namespace WebTheory\Leonidas\Library\Admin\Metabox\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class FieldGridView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'metabox/components/field-grid.twig';
}
