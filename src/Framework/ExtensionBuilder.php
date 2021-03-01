<?php

namespace WebTheory\Leonidas;

use Psr\Container\ContainerInterface;
use WebTheory\Leonidas\Framework\WpExtension;

class ExtensionBuilder
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
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of path
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set the value of url
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the value of prefix
     *
     * @param string $prefix
     *
     * @return self
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the value of container
     *
     * @param ContainerInterface $container
     *
     * @return self
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     *
     */
    public function finish()
    {
        return new WpExtension(
            $this->name,
            $this->path,
            $this->url,
            $this->prefix,
            $this->container
        );
    }

    /**
     *
     */
    public static function start()
    {
        return new static;
    }
}
