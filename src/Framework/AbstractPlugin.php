<?php

namespace WebTheory\Leonidas\Framework;

abstract class AbstractPlugin extends WpExtension
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $base;

    /**
     * @var string
     */
    protected $assets;

    /**
     *
     */
    public function __construct(
        string $url,
        string $path,
        string $base,
        string $assets
    ) {
        $this->url = $url;
        $this->path = $path;
        $this->base = $base;
        $this->assets = $assets;

        $this->init();
    }

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
