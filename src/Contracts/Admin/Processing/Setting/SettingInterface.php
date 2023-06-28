<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

interface SettingInterface
{
    public function getOptionGroup(): string;

    public function getOptionName(): string;

    public function getType(): ?string;

    public function getDescription(): ?string;

    public function getDefaultValue(): mixed;

    public function getRestSchema(): bool|array|null;

    public function getExtraArgs(): ?array;

    public function getValidator(): ValidatorInterface;

    public function getFormatter(): InputFormatterInterface;

    public function getNoticeFor(string $event): ?SettingNoticeInterface;
}
