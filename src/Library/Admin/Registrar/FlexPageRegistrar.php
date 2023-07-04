<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Callback\AdminPageCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

class FlexPageRegistrar implements FlexPageRegistrarInterface
{
    protected MenuPageRegistrarInterface $menuPageRegistrar;

    protected SubmenuPageRegistrarInterface $submenuPageRegistrar;

    protected InteriorPageRegistrarInterface $interiorPageRegistrar;

    protected AdminPageCallbackProviderInterface $callbackProvider;

    public function __construct(
        AdminPageCallbackProviderInterface $callbackProvider,
        ?MenuPageRegistrarInterface $menuPageRegistrar = null,
        ?SubmenuPageRegistrarInterface $submenuPageRegistrar = null,
        ?InteriorPageRegistrarInterface $interiorPageRegistrar = null,
    ) {
        $this->callbackProvider = $callbackProvider;

        $this->menuPageRegistrar = $menuPageRegistrar ?? $this->defaultMenuPageRegistrar();
        $this->submenuPageRegistrar = $submenuPageRegistrar ?? $this->defaultSubmenuPageRegistrar();
        $this->interiorPageRegistrar = $interiorPageRegistrar ?? $this->defaultInteriorPageRegistrar();
    }

    public function registerOne(FlexPageInterface $page, ServerRequestInterface $request)
    {
        $this->{$page->getContext()->value . "PageRegistrar"}->registerOne($page);
    }

    protected function getCallbackProvider(): AdminPageCallbackProviderInterface
    {
        return $this->callbackProvider;
    }

    protected function defaultMenuPageRegistrar(): MenuPageRegistrarInterface
    {
        return new MenuPageRegistrar($this->getCallbackProvider());
    }

    protected function defaultSubmenuPageRegistrar(): SubmenuPageRegistrarInterface
    {
        return new SubmenuPageRegistrar($this->getCallbackProvider());
    }

    protected function defaultInteriorPageRegistrar(): InteriorPageRegistrarInterface
    {
        return new InteriorPageRegistrar($this->getCallbackProvider());
    }
}
