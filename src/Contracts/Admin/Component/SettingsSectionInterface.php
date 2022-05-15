<?php

namespace Leonidas\Contracts\Admin\Component;

interface SettingsSectionInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getPage(): string;
}
