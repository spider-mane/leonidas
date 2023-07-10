<?php

namespace Leonidas\Contracts\Admin\Component\Notice;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;

interface AdminNoticeInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getField(): string;

    public function getMessage(): string;

    public function isDismissible(): bool;
}
