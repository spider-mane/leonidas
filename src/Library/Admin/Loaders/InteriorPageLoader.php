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
