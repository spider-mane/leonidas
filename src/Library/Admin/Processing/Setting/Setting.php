<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCapsuleInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

class Setting implements SettingInterface
{
    protected string $optionGroup;

    protected string $optionName;

    protected ?string $type = 'string';

    protected ?string $description;

    protected mixed $defaultValue;

    protected bool|array $restSchema;

    protected ?array $extraArgs = null;

    protected SettingCapsuleInterface $capsule;

    public function __construct(
        string $optionGroup,
        string $optionName,
        ?string $type = null,
        ?string $description = null,
        bool|array $restSchema = null,
        mixed $defaultValue = null,
        ?array $extraArgs = null,
        SettingCapsuleInterface $capsule
    ) {
        $this->optionGroup = $optionGroup;
        $this->optionName = $optionName;
        $this->capsule = $capsule;

        $type && $this->type = $type;
        $description && $this->description = $description;
        $restSchema && $this->restSchema = $restSchema;
        $defaultValue && $this->defaultValue = $defaultValue;
        $extraArgs && $this->extraArgs = $extraArgs;
    }

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

    public function getRestSchema(): bool|array|null
    {
        return $this->restSchema;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function getExtraArgs(): ?array
    {
        return $this->extraArgs;
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->capsule->validator($this);
    }

    public function getFormatter(): InputFormatterInterface
    {
        return $this->capsule->formatter($this);
    }

    public function getNoticeFor(string $event): ?SettingNoticeInterface
    {
        return $this->capsule->notice($event, $this);
    }
}
