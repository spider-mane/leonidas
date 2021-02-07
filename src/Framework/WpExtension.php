<?php

namespace WebTheory\Leonidas\Framework;

use Exception;
use League\Container\Container;
use Psr\Container\ContainerInterface;
use WebTheory\Leonidas\Admin\Contracts\WpExtensionInterface;

class WpExtension implements WpExtensionInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Leonidas
     */
    protected $master;

    /**
     *
     */
    protected const ACCEPTED_TYPES = ['theme', 'plugin', 'mu-plugin', 'mixin'];

    /**
     * @param string $name
     * @param string $path
     * @param string $url
     * @param string $prefix
     * @param string $type
     * @param ContainerInterface|null $container
     * @throws Exception
     */
    public function __construct(
        string $name,
        string $path,
        string $url,
        string $prefix,
        string $type,
        ?ContainerInterface $container = null
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->url = $url;
        $this->prefix = $prefix;
        $this->setType($type);
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * @param string $name
     * @param $default
     * @return mixed
     */
    public function config(string $name, $default)
    {
        return $this->get('config')->get($name, $default);
    }

    /**
     *
     */
    protected function getDefaultContainer(): ContainerInterface
    {
        return new Container();
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     * @throws Exception
     */
    protected function setType(string $type)
    {
        if (!in_array($type, static::ACCEPTED_TYPES)) {
            throw new Exception("{$type} is not an accepted extension type.");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of container
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
