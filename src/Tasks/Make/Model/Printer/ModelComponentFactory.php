<?php

namespace Leonidas\Tasks\Make\Model\Printer;

use Leonidas\Contracts\System\Model\DatableInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;

class ModelComponentFactory
{
    use ConvertsCaseTrait;

    protected string $model;

    protected string $namespace;

    protected string $contracts;

    protected string $abstracts;

    protected string $entity;

    protected string $single;

    protected string $plural;

    protected string $template;

    protected string $modelInterface;

    protected string $collectionInterface;

    protected string $abstractCollection;

    protected string $collection;

    protected string $query;

    protected string $repositoryInterface;

    protected string $repository;

    protected string $collectionFactory;

    protected string $queryFactory;

    protected string $modelConverter;

    protected string $getAccessProvider;

    protected string $setAccessProvider;

    protected string $tagAccessProvider;

    protected string $facades;

    protected function __construct(
        string $model,
        string $namespace,
        string $contracts,
        string $abstracts,
        string $facades,
        string $entity,
        string $single,
        string $plural,
        ?string $template = null
    ) {
        $this->namespace = $namespace;
        $this->contracts = $contracts;
        $this->abstracts = $abstracts;
        $this->facades = $facades;
        $this->entity = $entity;

        $this->template = $template ?? 'post';

        $this->single = $this->convert($single)->toCamel();
        $this->plural = $this->convert($plural)->toCamel();

        $model = $this->model = $this->convert($model)->toPascal();

        $this->modelInterface = $model . 'Interface';
        $this->collectionInterface = $model . 'CollectionInterface';
        $this->abstractCollection = 'Abstract' . $model . 'Collection';
        $this->collection = $model . 'Collection';
        $this->query = $model . 'Query';
        $this->repositoryInterface = $model . 'RepositoryInterface';
        $this->repository = $model . 'Repository';
        $this->modelConverter = $model . 'Converter';
        $this->collectionFactory = $model . 'CollectionFactory';
        $this->queryFactory = $model . 'QueryFactory';
        $this->getAccessProvider = $model . 'GetAccessProvider';
        $this->setAccessProvider = $model . 'SetAccessProvider';
        $this->tagAccessProvider = $model . 'TagAccessProvider';
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function getSingle(): string
    {
        return $this->single;
    }

    public function getPlural(): string
    {
        return $this->plural;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function isPostTemplate(): bool
    {
        return in_array($this->template, ['post', 'post:h', 'attachment']);
    }

    public function isTermTemplate(): bool
    {
        return in_array($this->template, ['term', 'term:h']);
    }

    public function isUserTemplate(): bool
    {
        return 'user' === $this->template;
    }

    public function isCommentTemplate(): bool
    {
        return 'comment' === $this->template;
    }

    public function getModelInterfacePrinter(): ModelInterfacePrinter
    {
        return new ModelInterfacePrinter(
            $this->contracts,
            $this->modelInterface,
            $this->template
        );
    }

    public function getModelPrinter(): ModelPrinter
    {
        return new ModelPrinter(
            $this->namespace,
            $this->model,
            $this->getContractFqn($this->modelInterface),
            $this->entity,
            $this->template
        );
    }

    public function getCollectionInterfacePrinter(): ModelCollectionInterfacePrinter
    {
        return new ModelCollectionInterfacePrinter(
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->plural,
            $this->contracts,
            $this->collectionInterface
        );
    }

    public function getCollectionPrinter(): ModelCollectionPrinter
    {
        return new ModelCollectionPrinter(
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->plural,
            $this->namespace,
            $this->collection,
            $this->getContractFqn($this->collectionInterface),
        );
    }

    public function getAbstractCollectionPrinter(): ModelCollectionAbstractPrinter
    {
        return new ModelCollectionAbstractPrinter(
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->plural,
            $this->abstracts,
            $this->abstractCollection,
            $this->getContractFqn($this->collectionInterface),
        );
    }

    public function getChildCollectionPrinter(): ModelCollectionAsChildPrinter
    {
        return new ModelCollectionAsChildPrinter(
            $this->getAbstractFqn($this->abstractCollection),
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->plural,
            $this->namespace,
            $this->collection,
            $this->getContractFqn($this->collectionInterface),
        );
    }

    public function getChildQueryPrinter(): ModelQueryAsChildPrinter
    {
        return new ModelQueryAsChildPrinter(
            $this->getAbstractFqn($this->abstractCollection),
            $this->model,
            $this->single,
            $this->plural,
            $this->namespace,
            $this->query,
            $this->getContractFqn($this->collectionInterface),
            $this->entity,
            $this->template
        );
    }

    public function getRepositoryInterfacePrinter(): ModelRepositoryInterfacePrinter
    {
        return new ModelRepositoryInterfacePrinter(
            $this->getContractFqn($this->modelInterface),
            $this->getContractFqn($this->collectionInterface),
            $this->single,
            $this->plural,
            $this->contracts,
            $this->repositoryInterface,
            $this->template
        );
    }

    public function getRepositoryPrinter(): ModelRepositoryPrinter
    {
        return new ModelRepositoryPrinter(
            $this->getContractFqn($this->modelInterface),
            $this->getContractFqn($this->collectionInterface),
            $this->single,
            $this->plural,
            $this->namespace,
            $this->repository,
            $this->getContractFqn($this->repositoryInterface),
            $this->template
        );
    }

    public function getModelConverterPrinter(): ModelConverterPrinter
    {
        return new ModelConverterPrinter(
            $this->namespace,
            $this->modelConverter,
            $this->getClassFqn($this->model),
            $this->getContractFqn($this->modelInterface),
            $this->template
        );
    }

    public function getCollectionFactoryPrinter(): ModelCollectionFactoryPrinter
    {
        return new ModelCollectionFactoryPrinter(
            $this->namespace,
            $this->collectionFactory,
            $this->getClassFqn($this->collection)
        );
    }

    public function getQueryFactoryPrinter(): ModelQueryFactoryPrinter
    {
        return new ModelQueryFactoryPrinter(
            $this->namespace,
            $this->queryFactory,
            $this->getClassFqn($this->query),
            $this->template
        );
    }

    public function getGetAccessProviderPrinter(): ModelGetAccessProviderPrinter
    {
        return new ModelGetAccessProviderPrinter(
            $this->namespace,
            $this->getAccessProvider,
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->isDatableModel()
        );
    }

    public function getSetAccessProviderPrinter(): ModelSetAccessProviderPrinter
    {
        return new ModelSetAccessProviderPrinter(
            $this->namespace,
            $this->setAccessProvider,
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->isMutableDatableModel()
        );
    }

    public function getTagAccessProviderPrinter(): ModelTemplateTagsProviderPrinter
    {
        return new ModelTemplateTagsProviderPrinter(
            $this->namespace,
            $this->tagAccessProvider,
            $this->getContractFqn($this->modelInterface),
            $this->single,
            $this->getClassFqn($this->getAccessProvider),
            $this->template
        );
    }

    public function getRepositoryFacadePrinter(): ModelRepositoryFacadePrinter
    {
        return new ModelRepositoryFacadePrinter(
            $this->convert($this->plural)->toPascal(),
            $this->facades,
            $this->getContractFqn($this->repositoryInterface),
            $this->getClassFqn($this->queryFactory),
            $this->getClassFqn($this->query),
            $this->template
        );
    }

    protected function isDatableModel(): bool
    {
        return interface_exists($this->modelInterface)
            && is_subclass_of($this->modelInterface, DatableInterface::class);
    }

    protected function isMutableDatableModel(): bool
    {
        return interface_exists($this->modelInterface)
            && is_subclass_of($this->modelInterface, MutableDatableInterface::class);
    }

    protected function getAbstractFqn(string $class): string
    {
        return $this->abstracts . '\\' . $class;
    }

    protected function getContractFqn(string $interface): string
    {
        return $this->contracts . '\\' . $interface;
    }

    protected function getClassFqn(string $class): string
    {
        return $this->namespace . '\\' . $class;
    }

    public static function build(array $args): ModelComponentFactory
    {
        return new static(
            $args['model'],
            $args['namespace'],
            $args['contracts'],
            $args['abstracts'],
            $args['facades'],
            $args['entity'],
            $args['single'],
            $args['plural'],
            $args['template'] ?? null
        );
    }
}
