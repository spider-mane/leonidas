<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractAdminPageRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class InteriorPageRegistrar extends AbstractAdminPageRegistrar implements InteriorPageRegistrarInterface
{
    public function registerOne(InteriorPageInterface $page, ServerRequestInterface $request)
    {
        add_submenu_page(
            $page->getParentSlug(),
            $page->getPageTitle(),
            '',
            $page->getCapability(),
            $page->getMenuSlug(),
            $this->getRenderingCallback($page, $request),
        );

        remove_submenu_page($page->getParentSlug(), $page->getMenuSlug());
    }
}
