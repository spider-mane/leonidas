<?php

namespace Leonidas\Contracts\Admin\Component\SettingsField;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;

interface SettingsFieldInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getPage(): string;

    public function getSection(): string;

    public function getInputId(): string;

    public function getArgs(): array;
}
