<?php

namespace Leonidas\Library\Admin\Setting;

use Leonidas\Contracts\Admin\Setting\SettingHandlerInterface;
use Leonidas\Contracts\Admin\Setting\SettingInterface;
use Leonidas\Library\Admin\Setting\Traits\HasSettingDataTrait;

class Setting implements SettingInterface
{
    use HasSettingDataTrait;

    public function __construct(
        string $optionGroup,
        string $optionName,
        ?string $type = null,
        ?string $description = null,
        ?SettingHandlerInterface $handler = null,
        $restSchema = null,
        $defaultValue = null,
        ?array $extraArgs = null
    ) {
        $this->optionGroup = $optionGroup;
        $this->optionName = $optionName;
        $this->handler = $handler;

        $type && $this->type = $type;
        $description && $this->description = $description;
        $restSchema && $this->restSchema = $restSchema;
        $defaultValue && $this->defaultValue = $defaultValue;
        $extraArgs && $this->extraArgs = $extraArgs;
    }
}
