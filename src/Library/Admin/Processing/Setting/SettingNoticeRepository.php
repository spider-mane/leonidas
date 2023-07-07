<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeDataStoreInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeRepositoryInterface;

class SettingNoticeRepository implements SettingNoticeRepositoryInterface
{
    public function __construct(protected SettingNoticeDataStoreInterface $data)
    {
        //
    }

    public function get(string $notice): ?SettingNoticeInterface
    {
        return ($data = $this->data->getNoticeData($notice))
            ? new SettingNotice(
                $data['id'],
                $data['message'],
                $data['type'] ?? null
            )
            : null;
    }
}
