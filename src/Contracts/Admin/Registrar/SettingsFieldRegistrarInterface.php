<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SettingsFieldRegistrarInterface
{
    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request);

    public function registerMany(SettingsFieldCollectionInterface $fields, ServerRequestInterface $request);
}
