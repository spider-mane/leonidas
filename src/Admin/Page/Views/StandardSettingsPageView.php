<?php

namespace WebTheory\Leonidas\Admin\Page\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class StandardSettingsPageView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     *
     */
    protected $template = 'page/layouts/settings-page.twig';
}
