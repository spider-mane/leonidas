<?php

namespace Leonidas\Contracts\Admin\Component\Notice;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;

interface AdminNoticeInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getMessage(): string;

    public function isDismissible(): bool;

    public function getScreen(): string;

    /**
     * @return null|int|int[]
     */
    public function getUsers();

    public function getField(): ?string;
}
