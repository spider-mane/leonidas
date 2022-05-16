<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;

class SubmenuPageRegistrar extends AbstractRegistrar implements SubmenuPageRegistrarInterface
{
    public function registerOne(SubmenuPageInterface $page)
    {
        add_submenu_page(
            $page->getParentSlug(),
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            $page->getMenuSlug(),
            $this->getOutputLoader()
        );
    }
}
