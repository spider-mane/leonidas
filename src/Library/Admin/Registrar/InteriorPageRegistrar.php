<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\InteriorPageInterface;
use Leonidas\Contracts\Admin\Component\InteriorPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;

class InteriorPageRegistrar extends AbstractRegistrar implements InteriorPageRegistrarInterface
{
    public function registerOne(InteriorPageInterface $page)
    {
        add_submenu_page(
            $page->getParentSlug(),
            $page->getPageTitle(),
            '',
            $page->getCapability(),
            $page->getMenuSlug(),
            $this->getOutputLoader(),
        );

        remove_submenu_page($page->getParentSlug(), $page->getMenuSlug());
    }
}
