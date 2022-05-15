<?php

namespace Leonidas\Contracts\Admin\Component;

interface SettingsSectionCollectionInterface
{
    public function add(SettingsSectionInterface $section);

    public function get(string $section): SettingsSectionInterface;

    public function remove(string $section);

    public function has(string $section): bool;

    /**
     * @return SettingsSectionInterface[]
     */
    public function all(): array;
}
