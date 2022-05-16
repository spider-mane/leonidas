<?php

namespace Leonidas\Contracts\Admin\Component\SettingsSection;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;

interface SettingsSectionInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getPage(): string;
}
