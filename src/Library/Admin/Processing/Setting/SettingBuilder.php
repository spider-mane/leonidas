<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingBuilderInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeRepositoryInterface;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

class SettingBuilder implements SettingBuilderInterface
{
    protected string $optionGroup;

    protected string $optionName;

    protected ?string $type = 'string';

    protected ?string $description;

    protected mixed $defaultValue;

    protected bool|array $restSchema;

    protected ?array $extraArgs = null;

    protected ?ValidatorInterface $validator;

    protected ?InputFormatterInterface $formatter;

    protected ?SettingNoticeRepositoryInterface $notices;

    public function __construct(string $optionName)
    {
        $this->optionName = $optionName;
    }

    public function group(string $optionGroup): static
    {
        $this->optionGroup = $optionGroup;

        return $this;
    }

    public function name(string $optionName): static
    {
        $this->optionName = $optionName;

        return $this;
    }

    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function schema($schema): static
    {
        $this->restSchema = $schema;

        return $this;
    }

    public function default($default): static
    {
        $this->defaultValue = $default;

        return $this;
    }

    public function extra(?array $extraArgs): static
    {
        $this->extraArgs = $extraArgs;

        return $this;
    }

    public function validator(?ValidatorInterface $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    public function formatter(?InputFormatterInterface $formatter): static
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function notices(?SettingNoticeRepositoryInterface $notices): static
    {
        $this->notices = $notices;

        return $this;
    }

    public function get(): Setting
    {
        return new Setting(
            $this->optionGroup,
            $this->optionName,
            $this->type,
            $this->description,
            $this->restSchema,
            $this->defaultValue,
            $this->extraArgs,
            $this->validator,
            $this->formatter,
            $this->notices
        );
    }

    public static function for(string $optionName): static
    {
        return new static($optionName);
    }
}
