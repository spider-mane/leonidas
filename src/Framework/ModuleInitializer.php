<?php

namespace WebTheory\Leonidas\Framework;

use InvalidArgumentException;
use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Contracts\Extension\ModuleInitializerInterface;
use WebTheory\Leonidas\Framework\Exceptions\InvalidModuleException;
use WebTheory\Leonidas\Framework\WpExtension;

class ModuleInitializer implements ModuleInitializerInterface
{
    /**
     * @var WpExtension
     */
    protected $extension;

    /**
     * @var array
     */
    protected $modules;

    public function __construct(WpExtension $extension, array $modules)
    {
        $this->extension = $extension;
        $this->modules = $modules;
    }

    public function init(): ModuleInitializerInterface
    {
        return $this->hookInModules();
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
        return in_array(
            $this->getValidModuleInterface(),
            class_implements($module)
        );
    }

    protected function getValidModuleInterface(): string
    {
        return ModuleInterface::class;
    }

    /**
     * Get the value of extension
     *
     * @return WpExtension
     */
    public function getExtension(): WpExtension
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
