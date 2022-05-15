<?php

namespace Leonidas\Library\Admin\Component\Metabox\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\Abstracts\AbstractTwigView;

class TabGroupView extends AbstractTwigView implements ViewInterface
{
    protected string $template = 'metabox/components/tab-group.twig';
}
