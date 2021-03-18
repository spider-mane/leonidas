<?php

namespace Leonidas\Framework;

use Exception;
use InvalidArgumentException;
use League\Container\Container;
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
     * @var string
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
     * @var ExtensionDependencyMap
     */
    protected $dependencies;

    /**
     * @var ExtensionDependentMap
     */
    protected $dependents;

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
        string $prefix,
        string $description,
        string $base,
        string $path,
        string $uri,
        string $assetUri,
        ExtensionType $type,
        ContainerInterface $container,
        bool $isInDev
    ) {
        $this->name = $name;
        $this->prefix = $prefix;
        $this->description = $description;
        $this->base = $base;
        $this->path = $path;
        $this->uri = rtrim($uri, '/');
        $this->type = $type;
        $this->assetUri = "{$this->uri}/{$assetUri}/";
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
     * Allows user to define a boolean constant present only in a development
     * environment. If the constant is present, returns the boolean value.
     *
     * @param string $const The name of a constant that should only be available
     * during development
     */
    public static function getDevStatusFromConstant(string $const): bool
    {
        return !empty($const) && constant($const) === true;
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
            $args['prefix'],
            $args['description'],
            $args['base'],
            $args['path'],
            $args['uri'],
            $args['assets'],
            $args['type'],
            $args['container'],
            $args['dev']
        );
    }
}
