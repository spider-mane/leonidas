<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Components\SubmenuPageLoaderInterface;

class SubmenuPageLoader implements SubmenuPageLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputLoader;

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    protected function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function addOne(SubmenuPageInterface $page)
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
