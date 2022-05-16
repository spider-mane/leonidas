<?php

namespace Leonidas\Contracts\Admin\Component\SettingsSection;

interface SettingsSectionBuilderInterface
{
    public function id(string $id);

    public function title(string $title);

    public function page(string $page);

    public function get(): SettingsSectionInterface;
}
