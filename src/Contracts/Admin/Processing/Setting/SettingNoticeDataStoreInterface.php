<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeDataStoreInterface
{
    /**
     * @return ?array<string,?string>
     */
    public function getNoticeData(string $notice): ?array;
}
