<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingCollectionInterface
{
    public function add(SettingInterface $setting);

    public function get(string $setting): SettingInterface;

    public function remove(string $setting);

    public function has(string $setting): bool;

    /**
     * @return SettingInterface[]
     */
    public function all(): array;
}
