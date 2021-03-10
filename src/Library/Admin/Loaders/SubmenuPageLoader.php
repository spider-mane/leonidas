<?php

namespace WebTheory\Leonidas\Library\Admin\Loaders;

use WebTheory\Leonidas\Contracts\Admin\Components\SubmenuPageInterface;

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
        $page = $this->adminPage;

        add_submenu_page(
            htmlspecialchars($page->getParentSlug()),
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            htmlspecialchars($page->getMenuSlug()),
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
