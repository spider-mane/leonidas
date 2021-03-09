<?php

namespace WebTheory\Leonidas\Contracts\Extension;

use Psr\Container\ContainerInterface;

interface WpExtensionInterface extends ContainerInterface
{
    /**
     * Get the name of the extension
     */
    public function getName(): string;

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
     * Get the base uri of the extension
     */
    public function getUri(): string;

    /**
     * @var null|array
     */
    public function getDependencies(): ?array;

    /**
     * @var null|array
     */
    public function getDependents(): ?array;

    /**
     * Get a configuration value
     */
    public function config(string $name, $default);

    /**
     * Get a directory relative to the base path
     */
    public function relPath(?string $file): ?string;

    /**
     * Get the absolute path of a file
     */
    public function absPath(?string $file): ?string;

    /**
     * Return a uri from the root uri
     */
    public function uri(?string $route): string;

    /**
     * Return the uri for the requested asset
     */
    public function asset(?string $asset = null): ?string;

    /**
     * Return a string that includes the extension prefix followed by the passed
     * delimiter followed by the passed value.
     */
    public function prefix(string $value, string $separator): string;

    /**
     * Returns the version if in the context of production and returns current
     * timestamp if in the context of app development. Useful as an automatic
     * cache busting mechanism when developing scripts and stylesheets as part
     * of an extension.
     *
     * @param string $version The actual version of the asset
     *
     * @return string Either the original version passed or a unix timestamp
     */
    public function vot(?string $version = null): ?string;

    /**
     * Determine whether or not the extension is in its development environment
     */
    public function isInDev(): bool;
}
