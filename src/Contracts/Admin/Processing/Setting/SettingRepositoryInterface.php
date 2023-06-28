<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingRepositoryInterface
{
    public function add(SettingInterface $setting): void;

    public function get(string $setting): SettingInterface;

    public function delete(string $setting): void;

    public function all(): SettingCollectionInterface;
}
