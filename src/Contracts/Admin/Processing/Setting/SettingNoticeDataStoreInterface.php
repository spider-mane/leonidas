<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeDataStoreInterface
{
    /**
     * @return array{id: string, message: string, type?: string}
     */
    public function getNoticeData(string $notice): ?array;
}
