<?php

namespace Leonidas\Contracts\Admin\Callback;

use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SettingsFieldCallbackProviderInterface
{
    /**
     * @return callable(array $args): void
     */
    public function getRenderingCallback(SettingsFieldInterface $field, ServerRequestInterface $request): callable;
}
