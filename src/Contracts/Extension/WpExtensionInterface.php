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
     * Return the declared namespace for use in certain code contexts such as
     * hook names.
     */
    public function getNamespace(): string;

    /**
     * Return a short prefix for use in prefixing values that may be globally
     * accessible and/or collide with other values. Examples include meta keys,
     * form input names, etc.
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
     * Get the base url of the extension
     */
    public function getUrl(): string;

    /**
     * Get the value of a header from the extension's main file
     */
    public function header(string $header): ?string;

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
    public function relPath(?string $file = null): ?string;

    /**
     * Get the absolute path of a file
     */
    public function absPath(?string $file = null): ?string;

    /**
     * Return a url from the root url
     */
    public function url(?string $route = null): string;

    /**
     * Return a string that includes the extension prefix followed by the passed
     * delimiter followed by the passed value.
     */
    public function namespace(string $value, string $separator = '/'): string;

    /**
     * Return a string that includes the extension prefix followed by the passed
     * delimiter followed by the passed value.
     */
    public function prefix(string $value, string $separator = '_'): string;

    /**
     * broadcasts a namespaced action event.
     *
     * @experimental
     */
    public function doAction(string $event, ...$data): void;

    /**
     * broadcasts a namespaced filter event.
     *
     * @experimental
     */
    public function applyFilters(string $attribute, $value, ...$data): void;

    /**
     * Determine whether or not the extension is in its development environment
     */
    public function isInDev(): bool;
}
