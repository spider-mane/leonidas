<?php

namespace Leonidas\Library\Admin\Page\Views;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Views\AbstractLeonidasTwigView;

class SimpleAdminPageView extends AbstractLeonidasTwigView implements ViewInterface
{
    protected string $template = 'page/layouts/admin-page.twig';
}
