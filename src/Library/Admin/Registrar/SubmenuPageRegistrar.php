<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractAdminPageRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class SubmenuPageRegistrar extends AbstractAdminPageRegistrar implements SubmenuPageRegistrarInterface
{
    public function registerOne(SubmenuPageInterface $page, ServerRequestInterface $request)
    {
        add_submenu_page(
            $page->getParentSlug(),
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            $page->getMenuSlug(),
            $this->getRenderingCallback($page, $request)
        );
    }
}
