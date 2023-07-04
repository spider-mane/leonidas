<?php

namespace Leonidas\Library\Admin\Registrar\Abstracts;

use Leonidas\Contracts\Admin\Callback\AdminPageCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\Page\BaseAdminPageInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAdminPageRegistrar
{
    public function __construct(protected AdminPageCallbackProviderInterface $callbackProvider)
    {
        //
    }

    protected function getRenderingCallback(BaseAdminPageInterface $page, ServerRequestInterface $request): callable
    {
        return $this->callbackProvider->getRenderingCallback($page, $request);
    }
}
