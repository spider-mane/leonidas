<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCapsuleInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

class SettingVessel implements SettingInterface
{
    public function __construct(protected SettingCapsuleInterface $capsule)
    {
        //
    }

    public function getOptionGroup(): string
    {
        return $this->capsule->group();
    }

    public function getOptionName(): string
    {
        return $this->capsule->name();
    }

    public function getType(): ?string
    {
        return $this->capsule->type();
    }

    public function getDescription(): ?string
    {
        return $this->capsule->description();
    }

    public function getRestSchema(): bool|array|null
    {
        return $this->capsule->rest();
    }

    public function getDefaultValue(): mixed
    {
        return $this->capsule->default();
    }

    public function getExtraArgs(): ?array
    {
        return $this->capsule->extra();
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->capsule->validator();
    }

    public function getFormatter(): InputFormatterInterface
    {
        return $this->capsule->formatter();
    }

    public function getNoticeFor(string $event): ?SettingNoticeInterface
    {
        return $this->capsule->notices()->get($event);
    }
}
