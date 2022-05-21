<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInitializerInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\ModuleInitializer;

abstract class AbstractModuleLibraryModule extends AbstractModule implements ModuleInterface
{
    public function hook(): void
    {
        $this->getModuleIetModuleInitializer()->init();
    }

    protected function getModuleIetModuleInitializer(): ModuleInitializerInterface
    {
        return new ModuleInitializer(
            $this->getExtension(),
            $this->getLibraryModules()
        );
    }

    abstract protected function getLibraryModules(): array;
}
