<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Coltrane\DependencyAssistant;
use Leonidas\Contracts\Dependency\DependencyAssistantInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Modules\AbstractModule;
use Leonidas\Traits\Hooks\TargetsActivatePluginHook;
use Leonidas\Traits\Hooks\TargetsDeactivatedPluginHook;

final class ManageComposerDependencies extends AbstractModule implements ModuleInterface
{
    use TargetsActivatePluginHook;
    use TargetsDeactivatedPluginHook;

    /**
     * @var DependencyAssistantInterface
     */
    protected $dependencyAssistant;

    public function __construct(WpExtensionInterface $extension)
    {
        $this->dependencyAssistant = $this->createDependencyAssistant();
        parent::__construct($extension);
    }

    public function hook(): void
    {
        $this->targetActivatePluginHook();
        $this->targetDeactivatedPluginHook();
    }

    protected function createDependencyAssistant(): DependencyAssistantInterface
    {
        return new DependencyAssistant();
    }

    protected function doActivatePluginAction(string $plugin, bool $networkWide): void
    {
        //
    }

    protected function doDeactivatedPluginAction(string $plugin, bool $networkWide): void
    {
        //
    }
}
