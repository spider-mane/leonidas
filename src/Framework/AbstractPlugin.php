<?php

namespace WebTheory\Leonidas\Framework;

abstract class AbstractPlugin
{
    /**
     *
     */
    public function init()
    {
        //
    }

    /**
     *
     */
    protected function registerActivationHook()
    {
        add_action('register_activation_hook', $this->activate());
    }

    /**
     *
     */
    protected function registerDeactivationHook()
    {
        add_action('register_deactivation_hook', $this->deactivate());
    }

    /**
     *
     */
    protected function registerUninstallHook()
    {
        add_action('register_uninstall_hook', $this->uninstall());
    }

    /**
     *
     */
    protected function activate(): ?callable
    {
        return null;
    }

    /**
     *
     */
    protected function deactivate(): ?callable
    {
        return null;
    }

    /**
     *
     */
    protected function uninstall(): ?callable
    {
        return null;
    }
}
