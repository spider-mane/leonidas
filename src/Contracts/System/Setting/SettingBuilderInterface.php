<?php

namespace Leonidas\Contracts\System\Setting;

interface SettingBuilderInterface
{
    public function optionGroup(string $optionGroup);

    public function optionName(string $optionName);

    public function type(?string $type);

    public function description(?string $description);

    public function handler(?SettingHandlerInterface $handler);

    /**
     * @param null|bool|array $schema
     */
    public function schema($schema);

    /**
     * @param mixed $default
     */
    public function default($default);

    public function extra(?array $args);

    public function get(): SettingInterface;
}
