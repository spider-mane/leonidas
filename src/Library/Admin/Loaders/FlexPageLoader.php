<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\Components\FlexPageInterface;
use Leonidas\Contracts\Admin\Components\FlexPageLoaderInterface;
use Leonidas\Contracts\Admin\Components\InteriorPageLoaderInterface;
use Leonidas\Contracts\Admin\Components\MenuPageLoaderInterface;
use Leonidas\Contracts\Admin\Components\SubmenuPageLoaderInterface;

class FlexPageLoader implements FlexPageLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputLoader;

    protected MenuPageLoaderInterface $menuPageLoader;

    protected SubmenuPageLoaderInterface $submenuPageLoader;

    protected InteriorPageLoaderInterface $interiorPageLoader;

    public function __construct(
        callable $outputLoader,
        ?MenuPageLoaderInterface $menuPageLoader = null,
        ?SubmenuPageLoaderInterface $submenuPageLoader = null,
        ?InteriorPageLoaderInterface $interiorPageLoader = null
    ) {
        $this->outputLoader = $outputLoader;
        $this->menuPageLoader = $menuPageLoader ?? $this->defaultMenuPageLoader();
        $this->submenuPageLoader = $submenuPageLoader ?? $this->defaultSubmenuPageLoader();
        $this->interiorPageLoader = $interiorPageLoader ?? $this->defaultInteriorPageLoader();
    }

    public function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function getMenuPageLoader(): MenuPageLoaderInterface
    {
        return $this->menuPageLoader;
    }

    public function getSubMenuPageLoader(): SubmenuPageLoaderInterface
    {
        return $this->submenuPageLoader;
    }

    public function getInteriorPageLoader(): InteriorPageLoaderInterface
    {
        return $this->interiorPageLoader;
    }

    public function addOne(FlexPageInterface $page)
    {
        $this->{$page->getContext()->value . "PageLoader"}->addOne($page);
    }

    protected function defaultMenuPageLoader(): MenuPageLoaderInterface
    {
        return new MenuPageLoader($this->getOutputLoader());
    }

    protected function defaultSubmenuPageLoader(): SubmenuPageLoaderInterface
    {
        return new SubmenuPageLoader($this->getOutputLoader());
    }

    protected function defaultInteriorPageLoader(): InteriorPageLoaderInterface
    {
        return new InteriorPageLoader($this->getOutputLoader());
    }
}
