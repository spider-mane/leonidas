<?php

namespace Leonidas\Contracts\Admin\Components;

interface SettingsFieldCollectionInterface
{
    public function add(SettingsFieldInterface $field);

    public function get(string $field): SettingsFieldInterface;

    public function remove(string $field);

    public function has(string $field): bool;

    /**
     * @return SettingsFieldInterface[]
     */
    public function all(): array;
}
