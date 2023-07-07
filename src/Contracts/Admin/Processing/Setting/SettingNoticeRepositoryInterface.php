<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeRepositoryInterface
{
    public function get(string $notice): ?SettingNoticeInterface;
}
