<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeRepositoryInterface;

class EmptySettingNoticeRepository implements SettingNoticeRepositoryInterface
{
    public function get(string $notice): ?SettingNoticeInterface
    {
        return null;
    }
}
