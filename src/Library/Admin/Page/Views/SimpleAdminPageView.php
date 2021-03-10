<?php

namespace WebTheory\Leonidas\Library\Admin\Page\Views;

use WebTheory\Leonidas\Contracts\Admin\Components\ViewInterface;
use WebTheory\Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class SimpleAdminPageView extends AbstractLeonidasTwigView implements ViewInterface
{
    /**
     * @var string
     */
    protected $template = 'page/layouts/admin-page.twig';
}
