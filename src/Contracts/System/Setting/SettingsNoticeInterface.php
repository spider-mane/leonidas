<?php

namespace Leonidas\Contracts\System\Setting;

interface SettingsNoticeInterface
{
    public function getCode(): string;

    public function getMessage(): string;

    public function getType(): string;
}
