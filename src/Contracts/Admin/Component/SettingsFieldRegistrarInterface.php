<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface SettingsFieldRegistrarInterface
{
    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request);

    public function registerMany(SettingsFieldCollectionInterface $fields, ServerRequestInterface $request);
}
