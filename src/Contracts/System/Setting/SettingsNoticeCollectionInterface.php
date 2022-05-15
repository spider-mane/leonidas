<?php

namespace Leonidas\Contracts\System\Setting;

interface SettingsNoticeCollectionInterface
{
    public function add(string $id, SettingsNoticeInterface $notice);

    public function get(string $notice): SettingsNoticeInterface;

    public function has(string $notice): bool;

    public function all(): array;
}
