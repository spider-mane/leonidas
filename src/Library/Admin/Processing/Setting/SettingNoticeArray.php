<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeDataStoreInterface;

class SettingNoticeArray implements SettingNoticeDataStoreInterface
{
    public function __construct(protected array $data)
    {
        //
    }

    public function getNoticeData(string $notice): ?array
    {
        return $this->data[$notice] ?? null;
    }
}
