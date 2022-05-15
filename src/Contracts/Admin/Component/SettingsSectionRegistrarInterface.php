<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface SettingsSectionRegistrarInterface
{
    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request);

    public function registerMany(SettingsSectionCollectionInterface $sections, ServerRequestInterface $request);
}
