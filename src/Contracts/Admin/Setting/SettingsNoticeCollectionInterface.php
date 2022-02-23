<?php

namespace Leonidas\Contracts\Admin\Setting;

interface SettingsNoticeCollectionInterface
{
    public function add(string $id, SettingsNoticeInterface $notice);

    public function get(string $notice): SettingsNoticeInterface;

    public function has(string $notice): bool;

    public function all(): array;
}
