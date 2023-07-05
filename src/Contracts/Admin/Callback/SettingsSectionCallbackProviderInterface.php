<?php

namespace Leonidas\Contracts\Admin\Callback;

use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SettingsSectionCallbackProviderInterface
{
    /**
     * @return callable(array $data): void
     */
    public function getRenderingCallback(SettingsSectionInterface $section, ServerRequestInterface $request): callable;
}
