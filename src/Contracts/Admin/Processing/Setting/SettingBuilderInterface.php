<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

interface SettingBuilderInterface
{
    /**
     * @return $this
     */
    public function group(string $optionGroup): static;

    /**
     * @return $this
     */
    public function name(string $optionName): static;

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
    public function validator(?ValidatorInterface $validator): static;

    /**
     * @return $this
     */
    public function formatter(?InputFormatterInterface $formatter): static;

    /**
     * @return $this
     */
    public function notices(?SettingNoticeRepositoryInterface $notices): static;

    /**
     * @return SettingInterface
     */
    public function get(): SettingInterface;
}
