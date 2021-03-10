<?php

namespace WebTheory\Leonidas\Library\Admin\Loaders;

use WebTheory\Leonidas\Contracts\Admin\Components\MenuPageInterface;

class MenuPageLoader extends AbstractAdminPageLoader
{
    /**
     * @var MenuPageInterface
     */
    protected $adminPage;

    /**
     *
     */
    public function __construct(MenuPageInterface $adminPage)
    {
        $this->adminPage = $adminPage;
    }

    protected function addPage(): AbstractAdminPageLoader
    {
        $adminPage = $this->adminPage;

        add_menu_page(
            $adminPage->getPageTitle(),
            $adminPage->getMenuTitle(),
            $adminPage->getCapability(),
            htmlspecialchars($adminPage->getMenuSlug()),
            [$this, 'renderPage'],
            $adminPage->getIconUrl(),
            $adminPage->getPosition()
        );

        return $this;
    }

    protected function removePage(): AbstractAdminPageLoader
    {
        remove_menu_page($this->menuSlug);

        return $this;
    }
}
