<?php

namespace WebTheory\Leonidas;

use League\Container\Container;
use WebTheory\Leonidas\Contracts\WpExtensionInterface;

class WpExtension implements WpExtensionInterface
{
    /**
     * @var Leonidas
     */
    protected $master;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $description;

    /**
     *
     */
    protected const ACCEPTED_TYPES = ['theme', 'plugin', 'mu-plugin', 'mixin'];

    /**
     *
     */
    public function __construct(
        string $name,
        string $prefix,
        string $type,
        string $description,
        ?Container $container = null
    ) {
        $this->name = $name;
        $this->prefix = $prefix;
        $this->type = $type;
        $this->description = $description;
        $this->container = $container ?? $this->getDefaultContainer();
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of prefix
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     *
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     *
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     *
     */
    public function config(string $name, $default)
    {
        return $this->get('config')->get($name, $default);
    }

    /**
     *
     */
    protected function getDefaultContainer(): Container
    {
        return new Container();
    }
}
