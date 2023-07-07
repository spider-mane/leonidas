<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeInterface
{
    public function getId(): string;

    public function getMessage(): string;

    public function getType(): ?string;
}
