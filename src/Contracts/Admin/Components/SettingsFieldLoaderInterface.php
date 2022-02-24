<?php

namespace Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface SettingsFieldLoaderInterface
{
    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request);

    public function registerMany(SettingsFieldCollectionInterface $fields, ServerRequestInterface $request);
}
