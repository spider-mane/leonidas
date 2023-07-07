<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;

class SettingNotice implements SettingNoticeInterface
{
    public function __construct(
        protected string $code,
        protected string $message,
        protected ?string $type = null
    ) {
        //
    }

    public function getId(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
