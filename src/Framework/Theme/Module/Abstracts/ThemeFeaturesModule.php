<?php

namespace Leonidas\Framework\Theme\Module\Abstracts;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsAfterSetupThemeHook;

abstract class ThemeFeaturesModule extends Module
{
    use TargetsAfterSetupThemeHook;

    public const IN_CORE = [
        'post-thumbnails',
        'post-formats',
        'html5',
        'custom-logo',
        'custom-header',
        'custom-background',
        'title-tag',
    ];

    public const CORE_DISABLE = [
        'disable-custom-colors',
        'disable-custom-gradients',
        'disable-custom-font-sizes',
    ];

    public const CORE_BOOL = [
        'automatic-feed-links',
        'custom-background',
        'custom-header',
        'custom-logo',
        'post-thumbnails',
        'title-tag',
    ];

    public const CORE_BASE = [
        'custom-background',
        'custom-header',
        'custom-logo',
        'html5',
        'post-formats',
    ];

    public const CORE_LIST = [];

    public const EXTRA_BOOL = [];

    public const EXTRA_BASE = [];

    public const EXTRA_LIST = [];

    public function hook(): void
    {
        $this->targetAfterSetupThemeHook();
    }

    protected function defineAfterSetUpThemePriority(): ?int
    {
        return PHP_INT_MAX;
    }

    protected function doAfterSetupThemeAction(): void
    {
        $this->addThemeFeatures();
    }

    protected function addThemeFeatures(): void
    {
        foreach ($this->features() as $feature => $args) {
            if ($this->isSupportedBoolFeature($feature, $args)) {
                add_theme_support($feature);
            } elseif ($this->isSupportedBaseFeature($feature, $args)) {
                add_theme_support($feature, $args);
            } elseif ($this->isSupportedListFeature($feature, $args)) {
                add_theme_support($feature, ...is_array($args) ? $args : [$args]);
            } elseif ($this->isDisabledFeature($feature, $args)) {
                remove_theme_support($feature);
            }
        }
    }

    protected function isSupportedBoolFeature(string $feature, $args)
    {
        return true === $args;
    }

    protected function isSupportedBaseFeature(string $feature, $args)
    {
        return !in_array($feature, $this->getVariadicFeatures())
            && !is_bool($args);
    }

    protected function isSupportedListFeature(string $feature, $args)
    {
        return in_array($feature, $this->getVariadicFeatures())
            && !is_bool($args);
    }

    protected function isDisabledFeature(string $feature, $args)
    {
        return current_theme_supports($feature) && false === $args;
    }

    public function getVariadicFeatures(): array
    {
        return array_merge(static::CORE_LIST, static::EXTRA_LIST);
    }

    abstract protected function features(): array;
}
