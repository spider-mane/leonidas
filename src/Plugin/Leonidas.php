<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\DependentExtensionListInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\Extension\ExtensionType;
use Leonidas\Framework\Exceptions\InvalidCallToPluginMethodException;

final class Leonidas
{
    /**
     * @var WpExtensionInterface
     */
    protected $base;

    /**
     * @var DependentExtensionListInterface
     */
    private $dependents;

    /**
     * @var Leonidas
     */
    private static $instance;

    private function __construct(WpExtensionInterface $base)
    {
        $this->base = $base;
        // $this->dependents = $base->get(DependentExtensionListInterface::class);
    }

    private function registerSupportedExtension(ExtensionType $type, string $name): Leonidas
    {
        $this->dependents->addDependency($type, $name);

        return $this;
    }

    public static function launch(WpExtensionInterface $base): void
    {
        if (!self::isLoaded()) {
            self::create($base);
        } else {
            self::throwInvalidCallException(__METHOD__);
        }
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance) && (self::$instance instanceof self);
    }

    private static function create(WpExtensionInterface $base): void
    {
        self::$instance = new self($base);
    }

    private static function throwInvalidCallException(callable $method): void
    {
        throw new InvalidCallToPluginMethodException(
            self::$instance->base->getName(),
            $method
        );
    }

    public static function supportExtension(ExtensionType $type, string $name): void
    {
        self::$instance->registerSupportedExtension($type, $name);
    }

    public static function supportTheme(string $name): void
    {
        self::supportExtension(ExtensionType::from('theme'), $name);
    }

    public static function supportPlugin(string $name): void
    {
        self::supportExtension(ExtensionType::from('plugin'), $name);
    }

    public static function supportMuPlugin(string $name): void
    {
        self::supportExtension(ExtensionType::from('mu-plugin'), $name);
    }

    public static function supportMixin(string $name): void
    {
        self::supportExtension(ExtensionType::from('mixin'), $name);
    }
}
