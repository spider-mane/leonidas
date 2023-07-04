<?php

namespace Leonidas\Contracts\Admin\Callback;

use Leonidas\Contracts\Admin\Component\Page\BaseAdminPageInterface;
use Psr\Http\Message\ServerRequestInterface;

interface AdminPageCallbackProviderInterface
{
    /**
     * @return callable(array $args): void
     */
    public function getRenderingCallback(BaseAdminPageInterface $page, ServerRequestInterface $request): callable;
}
