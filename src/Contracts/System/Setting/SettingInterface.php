<?php

namespace Leonidas\Contracts\System\Setting;

interface SettingInterface
{
    public function getOptionGroup(): string;

    public function getOptionName(): string;

    public function getType(): ?string;

    public function getDescription(): ?string;

    public function getHandler(): ?SettingHandlerInterface;

    /**
     * @return bool|array|null
     */
    public function getRestSchema();

    public function getDefaultValue();

    public function getExtraArgs(): ?array;
}
