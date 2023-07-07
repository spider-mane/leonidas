<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

interface SettingCapsuleInterface
{
    public function name(): string;

    public function group(): string;

    public function type(): string;

    public function description(): string;

    public function default(): mixed;

    public function rest(): bool|array|null;

    public function extra(): ?array;

    public function validator(): ValidatorInterface;

    public function formatter(): InputFormatterInterface;

    public function notices(): SettingNoticeRepositoryInterface;
}
