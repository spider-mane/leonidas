<?php

namespace Leonidas\Library\Admin\Setting\Traits;

use Leonidas\Contracts\Admin\Setting\SettingHandlerInterface;

trait HasSettingDataTrait
{
    protected string $optionGroup;

    protected string $optionName;

    protected ?string $type = 'string';

    protected ?string $description;

    protected ?SettingHandlerInterface $handler = null;

    protected mixed $defaultValue;

    /**
     * @var bool|array
     */
    protected $restSchema;

    protected ?array $extraArgs = null;

    public function getOptionGroup(): string
    {
        return $this->optionGroup;
    }

    public function getOptionName(): string
    {
        return $this->optionName;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getHandler(): ?SettingHandlerInterface
    {
        return $this->handler;
    }

    public function getRestSchema()
    {
        return $this->restSchema;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getExtraArgs(): ?array
    {
        return $this->extraArgs;
    }
}
