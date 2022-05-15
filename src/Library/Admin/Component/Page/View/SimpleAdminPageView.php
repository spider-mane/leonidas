<?php

namespace Leonidas\Library\Admin\Component\Page\View;

use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Component\Abstracts\AbstractTwigView;

class SimpleAdminPageView extends AbstractTwigView implements ViewInterface
{
    protected string $template = 'page/layouts/admin-page.twig';
}
