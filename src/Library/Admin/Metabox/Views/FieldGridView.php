<?php

namespace Leonidas\Library\Admin\Metabox\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class FieldGridView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected $template = 'metabox/components/field-grid.twig';
}
