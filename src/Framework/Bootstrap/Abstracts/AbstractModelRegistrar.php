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

    protected WpExtensionInterface $extension;

    protected ServiceContainerInterface $container;

    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $this->extension = $extension;
        $this->container = $container;

        foreach (get_class_methods($this) as $method) {
            if (str_ends_with($method, 'Services')) {
                $this->{$method}();
            }
        }
    }

    protected function register(string $model, string $entity, string $schema = 'post'): void
    {
        $parts = explode('\\', $model);
        $base = array_pop($parts);
        $namespace = implode('\\', $parts);

        if (str_ends_with($namespace, $base)) {
            $namespace = substr($namespace, 0, -strlen($base) - 1);
        }

        $converter = $model . 'Converter';
        $queryFactory = $model . 'QueryFactory';
        $repositoryInterface = sprintf(
            '%s\%s\%sRepositoryInterface',
            static::CONTRACTS ?: $namespace,
            $base,
            $base
        );

        $collectionFactory = $model . 'CollectionFactory';
        $repository = $model . 'Repository';
        $manager = static::ENTITY_MANAGERS[$schema];

        $this->container->share($converter, fn () => new $converter(
            $this->extension->get(AutoInvokerInterface::class),
        ));

        if (in_array($schema, ['post', 'attachment'])) {
            $this->container->share($queryFactory, fn () => new $queryFactory(
                $this->extension->get($converter),
            ));

            $repoCallback = fn () => new $repository(new $manager(
                $entity,
                $this->extension->get($converter),
                new $collectionFactory(),
                $this->extension->get($queryFactory),
            ));
        } else {
            $repoCallback = fn () => new $repository(new $manager(
                $entity,
                $this->extension->get($converter),
                new $collectionFactory(),
            ));
        }

        $this->container->share($repositoryInterface, $repoCallback);
    }
}
