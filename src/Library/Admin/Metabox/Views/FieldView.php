<?php

namespace Leonidas\Library\Admin\Metabox\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class FieldView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected string $template = 'metabox/components/field.twig';
}
