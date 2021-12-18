<?php

namespace Leonidas\Contracts\Extension;

use Psr\Container\ContainerInterface;

interface WpExtensionInterface extends ContainerInterface
{
    /**
     * Get the name of the extension
     */
    public function getName(): string;

    /**
     * Get the version of the extension
     */
    public function getVersion(): string;

    /**
     * Get the slug/textdomain of the extension
     */
    public function getSlug(): string;

    /**
     * Return a short prefix for use in prefixing values that may be globally
     * accessible and/or collide with other values
     */
    public function getPrefix(): string;

    /**
     * Optionally provide a description for the extension.
     */
    public function getDescription(): ?string;

    /**
     * Specify the type of extension i.e. Theme, Plugin, etc
     */
    public function getType(): string;

    /**
     * Get the plugin basename
     */
    public function getBase(): string;

    /**
     * Get the base url of the extension
     */
    public function getUrl(): string;

    /**
     * Get a configuration or option from the database value
     */
    public function config(string $key, $default = null);

    /**
     * Return whether or not a config value is present
     */
    public function hasConfig(string $key): bool;

    /**
     * Get a directory relative to the base path
     */
    public function relPath(?string $file): ?string;

    /**
     * Get the absolute path of a file
     */
    public function absPath(?string $file): ?string;

    /**
     * Return a url from the root url
     */
    public function url(?string $route): string;

    /**
     * Return the url for the requested asset
     */
    public function asset(?string $asset = null): ?string;

    /**
     * Return a string that includes the extension prefix followed by the passed
     * delimiter followed by the passed value.
     */
    public function prefix(string $value, string $separator): string;

    /**
     * Determine whether or not the extension is in its development environment
     */
    public function isInDev(): bool;
}
