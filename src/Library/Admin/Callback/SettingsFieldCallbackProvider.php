<?php

namespace Leonidas\Library\Admin\Callback;

use Leonidas\Contracts\Admin\Callback\SettingsFieldCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsFieldCallbackProvider implements SettingsFieldCallbackProviderInterface
{
    public function getRenderingCallback(SettingsFieldInterface $field, ServerRequestInterface $request): callable
    {
        return function (array $args) use ($field, $request): void {
            echo $field->renderComponent(
                $request->withAttribute('args', $args)
            );
        };
    }
}
