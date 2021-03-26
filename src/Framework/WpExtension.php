<?php

namespace Leonidas\Framework;

use Exception;
use InvalidArgumentException;
use League\Container\Container;
use Leonidas\Contracts\Extension\DependentExtensionListInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\ExtensionType;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;
use Respect\Validation\Rules\File;

class WpExtension implements WpExtensionInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $base;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $uri;

    /**
     * Asset base directory
     *
     * @var null|string
     */
    protected $assetUri;

    /**
     * @var ExtensionType
     */
    protected $type;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var bool
     */
    protected $isInDev;

    /**
     * @param string $name
     * @param string $path
     * @param string $uri
     * @param string $prefix
     * @param ExtensionType $type
     * @param ContainerInterface $container
     */
    public function __construct(
        string $name,
        string $version,
        string $description,
        string $prefix,
        string $base,
        string $path,
        string $uri,
        ExtensionType $type,
        ContainerInterface $container,
        bool $isInDev,
        ?string $assets = null
    ) {
        $this->name = $name;
        $this->version = $version;
        $this->prefix = $prefix;
        $this->description = $description;
        $this->base = $base;
        $this->path = $path;
        $this->uri = $uri;
        $this->type = $type;
        $this->container = $container;
        $this->isInDev = $isInDev;
        $assets && $this->assetUri = $this->uri . $assets;
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
     * Get the value of base
     *
     * @return string
     */
    public function getBase(): string
    {
        return $this->base;
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
     * Get the value of uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get the value of assetDir
     *
     * @return string
     */
    protected function getAssetDir(): string
    {
        return $this->assetUri;
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
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * {@inheritDoc}
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * {@inheritDoc}
     */
    public function config(string $name, $default = null)
    {
        return $this->get(ConfigInterface::class)->get($name, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function relPath(?string $file = null): ?string
    {
        return $this->getBase() . $file;
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
    public function uri(?string $route = null): string
    {
        return $this->getUri() . $route;
    }

    /**
     * {@inheritDoc}
     */
    public function asset(?string $asset = null): string
    {
        return $this->getAssetDir() . $asset;
    }

    /**
     * {@inheritDoc}
     */
    public function prefix(string $value, string $separator = '_'): string
    {
        return $this->getPrefix() . $separator . $value;
    }

    /**
     * {@inheritDoc}
     */
    public function vot(?string $version = null): ?string
    {
        return $this->isInDev() ? time() : $version;
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
            $args['description'],
            $args['prefix'],
            $args['base'],
            $args['path'],
            $args['uri'],
            $args['type'],
            $args['container'],
            $args['dev'] ?? false,
            $args['assets'] ?? null
        );
    }
}
