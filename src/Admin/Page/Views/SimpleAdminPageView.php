<?php

namespace WebTheory\Leonidas\Admin\Page\Views;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Views\AbstractLeonidasTwigView;

class SimpleAdminPageView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     * @var string
     */
    protected $template = 'page/layouts/admin-page.twig';
}
