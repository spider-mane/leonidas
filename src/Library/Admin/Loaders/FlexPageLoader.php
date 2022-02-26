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

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    public function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function addOne(FlexPageInterface $page)
    {
        switch ($page->getContext()->value) {
            case 'menu':
                $this->menuPageLoader()->addOne($page);
                break;

            case 'submenu':
                $this->submenuPageLoader()->addOne($page);
                break;

            case 'interior':
                $this->interiorPageLoader()->addOne($page);
                break;
        }
    }

    protected function menuPageLoader(): MenuPageLoaderInterface
    {
        return new MenuPageLoader($this->getOutputLoader());
    }

    protected function submenuPageLoader(): SubmenuPageLoaderInterface
    {
        return new SubmenuPageLoader($this->getOutputLoader());
    }

    protected function interiorPageLoader(): InteriorPageLoaderInterface
    {
        return new InteriorPageLoader($this->getOutputLoader());
    }
}
