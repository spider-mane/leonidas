<?php

namespace Leonidas\Framework;

use Exception;
use InvalidArgumentException;
use League\Container\Container;
use Leonidas\Contracts\Extension\DependentExtensionListInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\ExtensionType;
use Leonidas\Framework\Helpers\Plugin;
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
    protected $slug;

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
    protected $url;

    /**
     * Asset base directory
     *
     * @var null|string
     */
    protected $assetUrl;

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
     * @param string $url
     * @param string $prefix
     * @param ExtensionType $type
     * @param ContainerInterface $container
     */
    public function __construct(
        string $name,
        string $version,
        string $slug,
        string $prefix,
        string $description,
        string $base,
        string $path,
        string $url,
        string $type,
        ContainerInterface $container,
        bool $isInDev,
        ?string $assets = null
    ) {
        $this->name = $name;
        $this->version = $version;
        $this->slug = $slug;
        $this->prefix = $prefix;
        $this->description = $description;
        $this->base = $base;
        $this->path = $path;
        $this->url = $url;
        $this->type = $type;
        $this->container = $container;
        $this->isInDev = $isInDev;
        $assets && $this->assetUrl = $this->url . $assets;
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
     * Get the value of url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the value of assetDir
     *
     * @return string
     */
    protected function getAssetDir(): string
    {
        return $this->assetUrl;
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
        return $this->get('config')->get($name, $default);
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
    public function url(?string $route = null): string
    {
        return $this->getUrl() . $route;
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
    public function vot(?string $version = null): string
    {
        return $this->isInDev() ? time() : ($version ?? $this->getVersion());
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
            $args['textdomain'] ?? $args['slug'],
            $args['prefix'],
            $args['description'],
            $args['base'],
            $args['path'],
            $args['url'],
            $args['type'],
            $args['container'],
            $args['dev'] ?? false,
            $args['assets'] ?? null
        );
    }
}
