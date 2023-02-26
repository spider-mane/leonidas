<?php

namespace Leonidas\Framework\Bootstrap\Abstracts;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Comment\CommentEntityManager;
use Leonidas\Library\System\Schema\Post\AttachmentEntityManager;
use Leonidas\Library\System\Schema\Post\PostEntityManager;
use Leonidas\Library\System\Schema\Term\TermEntityManager;
use Leonidas\Library\System\Schema\User\UserEntityManager;
use Panamax\Contracts\ServiceContainerInterface;

abstract class AbstractModelRegistrar implements ExtensionBootProcessInterface
{
    protected const CONTRACTS = '';

    protected const ENTITY_MANAGERS = [
        'post' => PostEntityManager::class,
        'attachment' => AttachmentEntityManager::class,
        'term' => TermEntityManager::class,
        'user' => UserEntityManager::class,
        'comment' => CommentEntityManager::class,
    ];

    protected const QUERY_TYPES = ['post', 'attachment'];

    protected const MODEL_CONFIG = 'models';

    protected const DEFAULT_SCHEMA = 'post';

    protected WpExtensionInterface $extension;

    protected ServiceContainerInterface $container;

    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $this->extension = $extension;
        $this->container = $container;

        $this->bindModelServicesToContainer();
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
                $args['schema'] ?? static::DEFAULT_SCHEMA
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

    protected function register(string $model, string $entity, string $schema = self::DEFAULT_SCHEMA): void
    {
        $parts = explode('\\', $model);
        $base = array_pop($parts);
        $namespace = implode('\\', $parts);

        if (str_ends_with($namespace, $base)) {
            $namespace = substr($namespace, 0, -strlen($base) - 1);
        }

        $converter = $model . 'Converter';
        $repository = $model . 'Repository';
        $collectionFactory = $model . 'CollectionFactory';
        $manager = static::ENTITY_MANAGERS[$schema];
        $repositoryInterface = sprintf(
            '%s\%s\%sRepositoryInterface',
            static::CONTRACTS ?: $namespace,
            $base,
            $base
        );

        $this->container->share($converter, fn () => new $converter(
            $this->extension->get(AutoInvokerInterface::class),
        ));

        if (in_array($schema, static::QUERY_TYPES)) {
            $queryFactory = $model . 'QueryFactory';

            $this->container->share($queryFactory, fn () => new $queryFactory(
                $this->extension->get($converter),
            ));

            $repositoryFactory = fn () => new $repository(new $manager(
                $entity,
                $this->extension->get($converter),
                new $collectionFactory(),
                $this->extension->get($queryFactory),
            ));
        } else {
            $repositoryFactory = fn () => new $repository(new $manager(
                $entity,
                $this->extension->get($converter),
                new $collectionFactory(),
            ));
        }

        $this->container->share($repositoryInterface, $repositoryFactory);
    }
}
