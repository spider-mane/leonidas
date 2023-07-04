<?php

namespace Leonidas\Library\Admin\Callback;

use Leonidas\Contracts\Admin\Callback\AdminPageCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\Page\BaseAdminPageInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminPageCallbackProvider implements AdminPageCallbackProviderInterface
{
    public function getRenderingCallback(BaseAdminPageInterface $page, ServerRequestInterface $request): callable
    {
        return function (array $args) use ($page, $request): void {
            $request = $request->withAttribute('args', $args);
            $output = $page->shouldBeRendered($request)
                ? $page->renderComponent($request)
                : $page->getLoadErrorPage()->renderComponent($request);

            echo $output;
        };
    }
}
