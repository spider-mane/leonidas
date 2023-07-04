<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCallbackProviderInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingRegistrarInterface;

class SettingRegistrar implements SettingRegistrarInterface
{
    public function __construct(
        protected SettingCallbackProviderInterface $callbackProvider
    ) {
        //
    }

    public function registerOne(SettingInterface $setting)
    {
        register_setting(
            $setting->getOptionGroup(),
            $setting->getOptionName(),
            $this->getSettingArgs($setting)
        );
    }

    public function registerMany(SettingInterface ...$settings)
    {
        foreach ($settings as $setting) {
            $this->registerOne($setting);
        }
    }

    protected function getSettingArgs(SettingInterface $setting): array
    {
        $args = [
            'type' => $setting->getType(),
            'description' => $setting->getDescription(),
            'callback' => $this->getProcessingCallback($setting),
            'show_in_rest' => $setting->getRestSchema(),
            'default' => $setting->getDefaultValue(),
        ] + (array) $setting->getExtraArgs();

        return array_filter($args, fn ($arg) => null !== $arg);
    }

    protected function getProcessingCallback(SettingInterface $setting): callable
    {
        return $this->callbackProvider->getProcessingCallback($setting);
    }
}
