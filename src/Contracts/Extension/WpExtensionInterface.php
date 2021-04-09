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
    public function config(string $name, $default = null);

    // /**
    //  * Get an option from the database
    //  */
    // public function option(string $name, $default);

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
     * Returns the version if in the context of production and returns current
     * timestamp if in the context of app development. Useful as an automatic
     * cache busting mechanism when developing scripts and stylesheets as part
     * of an extension. If version is not provided and the extension is not in
     * development, this method must return the extension version.
     *
     * @param string $version The actual version of the asset
     *
     * @return string Either the original version passed or a unix timestamp
     */
    public function vot(?string $version = null): string;

    /**
     * Determine whether or not the extension is in its development environment
     */
    public function isInDev(): bool;
}
