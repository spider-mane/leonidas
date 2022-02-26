<?php

namespace Leonidas\Library\Admin\Setting;

use Leonidas\Contracts\Admin\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Setting\SettingRegistrarInterface;

class SettingRegistrar implements SettingRegistrarInterface
{
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
            'callback' => ($handler = $setting->getHandler())
                ? [$handler, 'filterInput']
                : null,
            'show_in_rest' => $setting->getRestSchema(),
            'default' => $setting->getDefaultValue(),
        ] + (array) $setting->getExtraArgs();

        return array_filter($args, fn ($arg) => null !== $arg);
    }
}
