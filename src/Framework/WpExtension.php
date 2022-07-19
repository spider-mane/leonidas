<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Plugin\Plugin;
use Leonidas\Framework\Theme\Theme;
use Psr\Container\ContainerInterface;

class WpExtension implements WpExtensionInterface
{
    protected string $name;

    protected string $version;

    protected string $slug;

    protected string $namespace;

    protected string $prefix;

    protected string $description;

    protected string $path;

    protected string $url;

    protected string $type;

    protected ContainerInterface $container;

    protected bool $isInDev;

    public function __construct(string $type, string $path, string $url, ContainerInterface $container)
    {
        $this->type = $type;
        $this->path = $path;
        $this->url = $url;
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name ??= $this->config('app.name');
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion(): string
    {
        return $this->version ??= $this->config('app.version');
    }

    /**
     * {@inheritDoc}
     */
    public function getSlug(): string
    {
        return $this->slug ??= $this->config('app.slug');
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace(): string
    {
        return $this->namespace ??= $this->config('app.namespace');
    }

    /**
     * {@inheritDoc}
     */
    public function getPrefix(): string
    {
        return $this->prefix ??= $this->config('app.prefix');
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return $this->description ??= $this->config('app.description');
    }

    /**
     * {@inheritDoc}
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
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
        return $this->isInDev ??= $this->config('app.dev');
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
    public function header(string $header): ?string
    {
        switch ($this->getType()) {
            case 'plugin':
                $headers = Plugin::headers(static::absPath('/plugin.php'));

                break;

            case 'theme':
                $headers = Theme::headers(static::absPath('/style.css'));

                break;
        }

        return $headers[$header] ?? null;
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
    public function namespace(string $value, string $separator = '/'): string
    {
        return $this->getNamespace() . $separator . $value;
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
    public function doAction(string $event, ...$data): void
    {
        do_action($this->namespace($event, '/'), ...$data);
    }

    /**
     * {@inheritDoc}
     */
    public function applyFilters(string $attribute, $value, ...$data): void
    {
        apply_filters($this->namespace($attribute, '/'), $value, ...$data);
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
            $args['type'],
            $args['path'],
            $args['url'],
            $args['container'],
        );
    }
}
