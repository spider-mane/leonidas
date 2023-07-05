<?php

namespace Leonidas\Library\Admin\Callback;

use Leonidas\Contracts\Admin\Callback\SettingsSectionCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsSectionCallbackProvider implements SettingsSectionCallbackProviderInterface
{
    public function getRenderingCallback(SettingsSectionInterface $section, ServerRequestInterface $request): callable
    {
        return function (array $data) use ($section, $request): void {
            echo $section->renderComponent(
                $request->withAttribute('section', $data)
            );
        };
    }
}
