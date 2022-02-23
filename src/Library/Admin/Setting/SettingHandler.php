<?php

namespace Leonidas\Library\Admin\Setting;

use Leonidas\Contracts\Admin\Setting\SettingHandlerInterface;
use Leonidas\Contracts\Admin\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Setting\SettingsNoticeCollectionInterface;
use Leonidas\Library\Admin\Processing\AbstractInputManager;
use WebTheory\Saveyour\Contracts\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\ValidatorInterface;

class SettingHandler extends AbstractInputManager implements SettingHandlerInterface
{
    protected SettingInterface $setting;

    protected SettingsNoticeCollectionInterface $notices;

    public function __construct(
        SettingInterface $setting,
        ValidatorInterface $validator,
        SettingsNoticeCollectionInterface $notices,
        InputFormatterInterface $formatter
    ) {
        $this->setting = $setting;
        $this->notices = $notices;
        parent::__construct($validator, $formatter);
    }

    public function getSetting(): SettingInterface
    {
        return $this->setting;
    }

    protected function returnIfFailed()
    {
        return get_option(
            $this->setting->getOptionName(),
            $this->setting->getDefaultValue()
        );
    }

    protected function handleRuleViolation($rule): void
    {
        $alert = $this->notices->get($rule);

        add_settings_error(
            $this->setting->getOptionName(),
            $alert->getCode(),
            $alert->getMessage(),
            $alert->getType()
        );
    }
}
