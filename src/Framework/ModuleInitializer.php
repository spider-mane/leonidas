<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\ModuleInitializerInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\Plugin\PluginModuleInterface;
use Leonidas\Contracts\Extension\Theme\ThemeModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exceptions\InvalidModuleException;

class ModuleInitializer implements ModuleInitializerInterface
{
    protected WpExtensionInterface $extension;

    protected array $modules = [];

    protected array $validModules = [
        ModuleInterface::class,
        PluginModuleInterface::class,
        ThemeModuleInterface::class,
    ];

    public function __construct(WpExtensionInterface $extension, array $modules)
    {
        $this->extension = $extension;
        $this->modules = $modules;
    }

    public function init(): void
    {
        $this->hookInModules();
    }

    protected function hookInModules(): ModuleInitializer
    {
        foreach ($this->getModules() as $module) {
            if ($this->isValidModule($module)) {
                /** @var ModuleInterface $module */
                $module = new $module($this->getExtension());
            } else {
                throw new InvalidModuleException($module);
            }

            $module->hook();
        }

        return $this;
    }

    protected function isValidModule($module): bool
    {
        if (!class_exists($module)) {
            return false;
        }

        $valid = false;

        foreach ($this->getValidModuleInterfaces() as $validModule) {
            if (in_array($validModule, class_implements($module))) {
                $valid = true;
            }
        }

        return $valid;
    }

    protected function getValidModuleInterfaces(): array
    {
        return $this->validModules;
    }

    /**
     * Get the value of extension
     *
     * @return WpExtensionInterface
     */
    public function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    /**
     * Get the value of modules
     *
     * @return array
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}
