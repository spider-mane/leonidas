<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;

class FlexPageRegistrar extends AbstractRegistrar implements FlexPageRegistrarInterface
{
    protected MenuPageRegistrarInterface $menuPageLoader;

    protected SubmenuPageRegistrarInterface $submenuPageLoader;

    protected InteriorPageRegistrarInterface $interiorPageLoader;

    public function __construct(
        callable $outputLoader,
        ?MenuPageRegistrarInterface $menuPageLoader = null,
        ?SubmenuPageRegistrarInterface $submenuPageLoader = null,
        ?InteriorPageRegistrarInterface $interiorPageLoader = null
    ) {
        parent::__construct($outputLoader);

        $this->menuPageLoader = $menuPageLoader ?? $this->defaultMenuPageRegistrar();
        $this->submenuPageLoader = $submenuPageLoader ?? $this->defaultSubmenuPageRegistrar();
        $this->interiorPageLoader = $interiorPageLoader ?? $this->defaultInteriorPageRegistrar();
    }

    public function registerOne(FlexPageInterface $page)
    {
        $this->{$page->getContext()->value . "PageLoader"}->registerOne($page);
    }

    protected function getMenuPageRegistrar(): MenuPageRegistrarInterface
    {
        return $this->menuPageLoader;
    }

    protected function getSubMenuPageRegistrar(): SubmenuPageRegistrarInterface
    {
        return $this->submenuPageLoader;
    }

    protected function getInteriorPageRegistrar(): InteriorPageRegistrarInterface
    {
        return $this->interiorPageLoader;
    }

    protected function defaultMenuPageRegistrar(): MenuPageRegistrarInterface
    {
        return new MenuPageRegistrar($this->getOutputLoader());
    }

    protected function defaultSubmenuPageRegistrar(): SubmenuPageRegistrarInterface
    {
        return new SubmenuPageRegistrar($this->getOutputLoader());
    }

    protected function defaultInteriorPageRegistrar(): InteriorPageRegistrarInterface
    {
        return new InteriorPageRegistrar($this->getOutputLoader());
    }
}
