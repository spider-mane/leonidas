<?php

namespace WebTheory\Leonidas\Framework;

use Exception;
use InvalidArgumentException;
use League\Container\Container;
use Psr\Container\ContainerInterface;
use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Admin\Contracts\WpExtensionInterface;
use WebTheory\Leonidas\Framework\Enum\ExtensionType;

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
    protected $assetDir;

    /**
     * @var ExtensionType
     */
    protected $type;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Name of a constant that will return true if the extension is in its
     * development environment
     *
     * @var string
     */
    protected $dev;

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
        string $prefix,
        string $path,
        string $url,
        string $assetDir,
        ExtensionType $type,
        ContainerInterface $container,
        string $dev
    ) {
        $this->name = $name;
        $this->path = realpath($path);
        $this->url = realpath($url);
        $this->prefix = $prefix;
        $this->type = $type->getValue();
        $this->assetDir = realpath("{$this->url}/{$assetDir}");
        $this->container = $container;
        $this->dev = $dev;
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
        return $this->assetDir;
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
    public function file(?string $file): ?string
    {
        $file = $file ?? '';

        return realpath($this->getPath() . $file);
    }

    /**
     * {@inheritDoc}
     */
    public function asset(?string $asset = null): string
    {
        $asset = $asset ?? '';

        return realpath($this->getAssetDir() . "/{$asset}");
    }

    /**
     * {@inheritDoc}
     */
    public function prefix(string $value, string $delimiter = '_'): string
    {
        return $this->getPrefix() . $delimiter . $value;
    }

    /**
     * {@inheritDoc}
     */
    public function vot(?string $version = null): ?string
    {
        return $this->isInDev() ? time() : $version;
    }

    /**
     * {@inheritDoc}
     */
    public function isInDev(): bool
    {
        $const = $this->dev;

        return !empty($const) && defined($const) && true === constant($const);
    }

    public static function create(array $args): WpExtension
    {
        return new static(
            $args['name'],
            $args['prefix'],
            $args['path'],
            $args['uri'],
            $args['asset_dir'],
            $args['type'],
            $args['container'],
            $args['dev']
        );
    }
}
