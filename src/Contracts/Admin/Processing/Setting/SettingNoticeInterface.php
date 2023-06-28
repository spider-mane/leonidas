<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeInterface
{
    public function getCode(): string;

    public function getMessage(): string;

    public function getType(): string;
}
