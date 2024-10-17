<?php

namespace Leonidas\Framework\Bootstrap\Abstracts;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Bootstrap\Api\ModelRepositoryApi;
use Panamax\Contracts\ServiceContainerInterface;

abstract class AbstractModelRegistrar implements ExtensionBootProcessInterface
{
    protected const MODELS = '';

    protected const CONTRACTS = '';

    protected const MODEL_CONFIG = 'models';

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
        return new ModelRepositoryApi(
            $this->container,
            static::MODELS,
            static::CONTRACTS
        );
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

        foreach ($models as $name => $args) {
            $this->register(
                $args['model'],
                $name,
                $args['schema'],
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

    protected function register(string $model, string $name, string $schema, array $entries = []): void
    {
        $this->api->register($model, $name, $schema, $entries);
    }

    public function registerPost(string $model, string $name, array $entries = []): void
    {
        $this->api->registerPost($model, $name, $entries);
    }

    protected function registerAttachment(string $model, string $mime, array $entries = []): void
    {
        $this->api->registerAttachment($model, $mime, $entries);
    }

    public function registerTerm(string $model, string $name, array $entries = []): void
    {
        $this->api->registerTerm($model, $name, $entries);
    }

    public function registerUser(string $model, string $name, array $entries = []): void
    {
        $this->api->registerUser($model, $name, $entries);
    }

    public function registerComment(string $model, string $name, array $entries = []): void
    {
        $this->api->registerComment($model, $name, $entries);
    }
}
