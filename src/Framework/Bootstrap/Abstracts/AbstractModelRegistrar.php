<?php

namespace Leonidas\Framework\Bootstrap\Abstracts;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Bootstrap\Api\ModelRepositoryApi;
use Panamax\Contracts\ServiceContainerInterface;

abstract class AbstractModelRegistrar implements ExtensionBootProcessInterface
{
    protected const CONTRACTS = '';

    protected const MODEL_CONFIG = 'models';

    protected const DEFAULT_SCHEMA = 'post';

    protected WpExtensionInterface $extension;

    protected ServiceContainerInterface $container;

    protected ModelRepositoryApi $api;

    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $this->extension = $extension;
        $this->container = $container;
        $this->api = $this->getApi();

        $this->bindModelServicesToContainer();
    }

    protected function getApi(): ModelRepositoryApi
    {
        return new ModelRepositoryApi($this->container, static::CONTRACTS);
    }

    protected function bindModelServicesToContainer(): void
    {
        $this->registerFromConfig()->registerFromMethods();
    }

    /**
     * @return $this
     */
    protected function registerFromConfig(): self
    {
        $models = $this->extension->config(static::MODEL_CONFIG, []);

        foreach ($models as $entity => $args) {
            $this->register(
                $args['model'],
                $entity,
                $args['schema'] ?? static::DEFAULT_SCHEMA,
                $args['entries'] ?? [],
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerFromMethods(): self
    {
        foreach (get_class_methods($this) as $method) {
            if (str_ends_with($method, 'Services')) {
                $this->{$method}();
            }
        }

        return $this;
    }

    protected function register(string $model, string $entity, string $schema = self::DEFAULT_SCHEMA, array $entries = []): void
    {
        $this->api->register($model, $entity, $schema, $entries);
    }
}
