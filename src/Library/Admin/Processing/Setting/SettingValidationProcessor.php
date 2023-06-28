<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInjectorInterface;
use Leonidas\Contracts\Option\OptionRepositoryInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidationProcessorInterface;

class SettingValidationProcessor implements ValidationProcessorInterface
{
    public function __construct(
        protected SettingInterface $setting,
        protected OptionRepositoryInterface $optionRepository,
        protected SettingNoticeInjectorInterface $noticeInjector
    ) {
        //
    }

    public function returnOnFailure(): mixed
    {
        return $this->optionRepository->get(
            $this->setting->getOptionName(),
            $this->setting->getDefaultValue()
        );
    }

    public function handleRuleViolation(string $rule): void
    {
        if ($notice = $this->setting->getNoticeFor($rule)) {
            $this->noticeInjector->inject($this->setting, $notice);
        }
    }
}
