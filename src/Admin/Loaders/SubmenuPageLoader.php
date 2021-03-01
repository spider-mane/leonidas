<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use WebTheory\Leonidas\Admin\Contracts\SubmenuPageInterface;

class SubmenuPageLoader extends AbstractAdminPageLoader
{
    /**
     * @var SubmenuPageInterface
     */
    protected $adminPage;

    /**
     *
     */
    public function __construct(SubmenuPageInterface $adminPage)
    {
        $this->adminPage = $adminPage;
    }

    protected function addPage(): AbstractAdminPageLoader
    {
        add_submenu_page(
            htmlspecialchars($this->adminPage->getParentSlug()),
            $this->adminPage->getPageTitle(),
            $this->adminPage->getMenuTitle(),
            $this->adminPage->getCapability(),
            htmlspecialchars($this->adminPage->getMenuSlug()),
            [$this, 'renderPage']
        );

        return $this;
    }

    protected function configurePage(): AbstractAdminPageLoader
    {
        parent::configurePage();

        $this->targetSubmenuFileHook()->targetParentFileHook();

        return $this;
    }

    protected function removePage(): AbstractAdminPageLoader
    {
        remove_submenu_page($this->parentSlug, $this->menuSlug);

        return $this;
    }

    protected function targetSubmenuFileHook(): SubmenuPageLoader
    {
        add_filter('submenu_file', [$this, 'resolveSubmenuFile'], null, PHP_INT_MAX);

        return $this;
    }

    protected function targetParentFileHook(): SubmenuPageLoader
    {
        add_filter('parent_file', [$this, 'resolveParentFile'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    public function resolveSubmenuFile(string $submenuFile, string $parentFile): string
    {
        return $this->adminPage->defineSubmenuFile($submenuFile, $parentFile);
    }

    /**
     *
     */
    public function resolveParentFile(string $parentFile): string
    {
        return $this->adminPage->defineParentFile($parentFile);
    }
}
