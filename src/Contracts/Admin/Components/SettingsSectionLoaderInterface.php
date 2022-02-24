<?php

namespace Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface SettingsSectionLoaderInterface
{
    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request);

    public function registerMany(SettingsSectionCollectionInterface $sections, ServerRequestInterface $request);
}
