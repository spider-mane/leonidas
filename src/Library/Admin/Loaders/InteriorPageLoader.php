<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\Components\InteriorPageInterface;
use Leonidas\Contracts\Admin\Components\InteriorPageLoaderInterface;

class InteriorPageLoader implements InteriorPageLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputLoader;

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    public function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function addOne(InteriorPageInterface $page)
    {
        $menuSlug = $this->getEscapedSlug($page->getParentSlug());
        $submenuSlug = $this->getEscapedMenuSlug($page->getMenuSlug());

        add_submenu_page(
            $menuSlug,
            $page->getPageTitle(),
            '',
            $page->getCapability(),
            $submenuSlug,
            $this->getOutputLoader()
        );

        remove_submenu_page($menuSlug, $submenuSlug);
    }

    protected function getEscapedSlug(string $slug)
    {
        return htmlspecialchars($slug);
    }

    protected function getEscapedMenuSlug(string $menuSlug)
    {
        return htmlspecialchars($menuSlug);
    }
}
