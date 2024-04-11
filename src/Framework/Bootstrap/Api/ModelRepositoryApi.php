<?php

namespace Leonidas\Framework\Bootstrap\Api;

use Closure;
use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Factory\CommentEntityConverter;
use Leonidas\Library\System\Model\Factory\EntityCollectionFactory;
use Leonidas\Library\System\Model\Factory\PostEntityConverter;
use Leonidas\Library\System\Model\Factory\PostEntityQueryFactory;
use Leonidas\Library\System\Model\Factory\TermEntityConverter;
use Leonidas\Library\System\Model\Factory\UserEntityConverter;
use Leonidas\Library\System\Schema\Comment\CommentEntityManager;
use Leonidas\Library\System\Schema\Post\AttachmentEntityManager;
use Leonidas\Library\System\Schema\Post\PostEntityManager;
use Leonidas\Library\System\Schema\Term\TermEntityManager;
use Leonidas\Library\System\Schema\User\UserEntityManager;
use Panamax\Contracts\ServiceContainerInterface;
use UnexpectedValueException;

class ModelRepositoryApi
{
    public function __construct(
        protected ServiceContainerInterface $container,
        protected string $contracts = ''
    ) {
        //
    }

    public function register(string $model, string $name, string $schema, array $entries = []): void
    {
        $this->container->share(
            $this->getRepositoryType($model),
            $this->getModelRepositoryFactory($model, $name, $schema, $entries)
        );
    }

    protected function getModelRepositoryFactory(string $model, string $name, string $schema, array $entries): Closure
    {
        return match ($schema) {
            'post' => $this->postModelRepository($model, $name, $entries),
            'attachment' => $this->attachmentModelRepository($model, $name, $entries),
            'term' => $this->termModelRepository($model, $name, $entries),
            'user' => $this->userModelRepository($model, $name, $entries),
            'comment' => $this->commentModelRepository($model, $name, $entries),
            default => throw new UnexpectedValueException(
                "Invalid schema: \"{$schema}\""
            )
        };
    }

    protected function postModelRepository(string $model, string $type, array $entries): Closure
    {
        $repositoryClass = $this->getRepositoryClass($model);
        $modelType = $this->getModelType($model);
        $collectionClass = $this->getCollectionClass($model);
        $queryClass = $this->getQueryClass($model);

        return fn () => new $repositoryClass(new PostEntityManager(
            $type,
            $converter = new PostEntityConverter(
                $modelType,
                $model,
                $this->getInvoker()
            ),
            new EntityCollectionFactory($collectionClass),
            $this->getRelatablePostKeys(),
            new PostEntityQueryFactory($queryClass, $converter),
            null,
            $entries
        ));
    }

    protected function attachmentModelRepository(string $model, string $type, array $entries): Closure
    {
        $repositoryClass = $this->getRepositoryClass($model);
        $modelType = $this->getModelType($model);
        $collectionClass = $this->getCollectionClass($model);
        $queryClass = $this->getQueryClass($model);

        return fn () => new $repositoryClass(new AttachmentEntityManager(
            $type,
            $converter = new PostEntityConverter(
                $modelType,
                $model,
                $this->getInvoker()
            ),
            new EntityCollectionFactory($collectionClass),
            $this->getRelatablePostKeys(),
            new PostEntityQueryFactory($queryClass, $converter),
            null,
            $entries
        ));
    }

    protected function termModelRepository(string $model, string $type, array $entries): Closure
    {
        $repositoryClass = $this->getRepositoryClass($model);
        $modelType = $this->getModelType($model);
        $collectionClass = $this->getCollectionClass($model);

        return fn () => new $repositoryClass(new TermEntityManager(
            $type,
            new TermEntityConverter(
                $modelType,
                $model,
                $type,
                $this->getInvoker()
            ),
            new EntityCollectionFactory($collectionClass),
            $entries
        ));
    }

    protected function userModelRepository(string $model, string $type, array $entries): Closure
    {
        $repositoryClass = $this->getRepositoryClass($model);
        $modelType = $this->getModelType($model);
        $collectionClass = $this->getCollectionClass($model);

        return fn () => new $repositoryClass(new UserEntityManager(
            $type,
            new UserEntityConverter($modelType, $model, $this->getInvoker()),
            new EntityCollectionFactory($collectionClass),
            $entries
        ));
    }

    protected function commentModelRepository(string $model, string $type, array $entries): Closure
    {
        $repositoryClass = $this->getRepositoryClass($model);
        $modelType = $this->getModelType($model);
        $collectionClass = $this->getCollectionClass($model);

        return fn () => new $repositoryClass(new CommentEntityManager(
            $type,
            new CommentEntityConverter($modelType, $model, $this->getInvoker()),
            new EntityCollectionFactory($collectionClass),
            $entries
        ));
    }

    protected function getType(string $model, string $thing = '')
    {
        $template = '%s\%s\%sInterface';

        $parts = explode('\\', $model);
        $base = array_pop($parts);

        if (!$namespace = $this->contracts) {
            if (end($parts) === $base) {
                array_pop($parts);
            }

            $namespace = implode('\\', $parts);
        }

        return sprintf($template, $namespace, $base, $base . $thing);
    }

    protected function getRepositoryType(string $model): string
    {
        return $this->getType($model, 'Repository');
    }

    protected function getModelType(string $model): string
    {
        return $this->getType($model);
    }

    protected function getRepositoryClass(string $model): string
    {
        return $model . 'Repository';
    }

    protected function getCollectionClass(string $model): string
    {
        return $model . 'Collection';
    }

    protected function getQueryClass(string $model): string
    {
        return $model . 'Query';
    }

    protected function getInvoker(): AutoInvokerInterface
    {
        return $this->container->get(AutoInvokerInterface::class);
    }

    protected function getRelatablePostKeys(): RelatablePostKeyInterface
    {
        return $this->container->get(RelatablePostKeyInterface::class);
    }
}
