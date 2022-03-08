<?php

namespace Leonidas\Library\Admin\Page\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class StandardSettingsPageView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected $template = 'page/layouts/settings-page.twig';
}
