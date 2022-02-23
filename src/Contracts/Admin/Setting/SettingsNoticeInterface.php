<?php

namespace Leonidas\Contracts\Admin\Setting;

interface SettingsNoticeInterface
{
    public function getCode(): string;

    public function getMessage(): string;

    public function getType(): string;
}
