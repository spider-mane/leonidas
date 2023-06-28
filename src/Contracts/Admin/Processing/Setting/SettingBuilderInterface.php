<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingBuilderInterface
{
    /**
     * @return $this
     */
    public function optionGroup(string $optionGroup): static;

    /**
     * @return $this
     */
    public function optionName(string $optionName): static;

    /**
     * @return $this
     */
    public function type(?string $type): static;

    /**
     * @return $this
     */
    public function description(?string $description): static;

    /**
     * @return $this
     */
    public function schema(null|bool|array $schema): static;

    /**
     * @return $this
     */
    public function default(mixed $default): static;

    /**
     * @return $this
     */
    public function extra(?array $args): static;

    /**
     * @return $this
     */
    public function capsule(SettingCapsuleInterface $capsule): static;

    /**
     * @return SettingInterface
     */
    public function get(): SettingInterface;
}
