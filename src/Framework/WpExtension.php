<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\Extension\ExtensionType;
use Psr\Container\ContainerInterface;

class WpExtension implements WpExtensionInterface
{
    protected string $name;

    protected string $version;

    protected string $slug;

    protected string $prefix;

    protected string $description;

    protected string $file;

    protected string $path;

    protected string $url;

    protected string $type;

    protected ContainerInterface $container;

    protected bool $isInDev;

    public function __construct(
        string $name,
        string $version,
        string $slug,
        string $prefix,
        string $description,
        string $file,
        string $path,
        string $url,
        string $type,
        ContainerInterface $container,
        bool $isInDev
    ) {
        $this->name = $name;
        $this->version = $version;
        $this->slug = $slug;
        $this->prefix = $prefix;
        $this->description = $description;
        $this->file = $file;
        $this->path = $path;
        $this->url = $url;
        $this->type = $type;
        $this->container = $container;
        $this->isInDev = $isInDev;
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
     * Get the value of version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    public function getSlug(): string
    {
        return $this->slug;
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
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the value of path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the value of url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function isInDev(): bool
    {
        return $this->isInDev;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * {@inheritDoc}
     */
    public function config(string $key, $default = null)
    {
        return $this->get('config')->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function hasConfig(string $key): bool
    {
        return $this->get('config')->has($key);
    }

    /**
     * {@inheritDoc}
     */
    public function relPath(?string $file = null): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function absPath(?string $file = null): ?string
    {
        return $this->getPath() . $file;
    }

    /**
     * {@inheritDoc}
     */
    public function url(?string $route = null): string
    {
        return $this->getUrl() . $route;
    }

    /**
     * {@inheritDoc}
     */
    public function prefix(string $value, string $separator = '_'): string
    {
        return $this->getPrefix() . $separator . $value;
    }

    /**
     * Returns a new instance of WpExtension using values in the array passed.
     *
     * @param array $args
     *
     * @return WpExtension
     */
    public static function create(array $args): WpExtension
    {
        return new static(
            $args['name'],
            $args['version'],
            $args['slug'] ?? $args['textdomain'],
            $args['prefix'],
            $args['description'],
            $args['file'],
            $args['path'],
            $args['url'],
            ExtensionType::from($args['type']),
            $args['container'],
            $args['dev'] ?? false,
        );
    }
}
