<?php

namespace Leonidas\Library\Admin\Component\Page\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\Abstracts\AbstractTwigView;

class StandardSettingsPageView extends AbstractTwigView implements ViewInterface
{
    protected string $view = 'page.layouts.settings-page';
}
