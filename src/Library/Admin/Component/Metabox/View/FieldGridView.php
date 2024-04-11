<?php

namespace Leonidas\Library\Admin\Component\Metabox\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\Abstracts\AbstractTwigView;

class FieldGridView extends AbstractTwigView implements ViewInterface
{
    protected string $view = 'metabox.components.field-grid';
}
