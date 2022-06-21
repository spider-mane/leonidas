<?php

namespace Leonidas\Console\Library;

class ModelCollectionsFactory
{
    protected string $model;

    protected string $namespace;

    protected string $contracts;

    protected string $abstracts;

    protected string $type;

    protected string $abstract;

    protected string $collection;

    protected string $query;

    protected string $entity;

    protected string $single;

    protected string $plural;

    protected string $template;

    protected function __construct(
        string $model,
        string $namespace,
        string $contracts,
        string $abstracts,
        string $type,
        string $abstract,
        string $collection,
        string $query,
        string $entity,
        string $single,
        string $plural,
        string $template = 'post'
    ) {
        $this->model = $model;
        $this->namespace = $namespace;
        $this->contracts = $contracts;
        $this->abstracts = $abstracts;
        $this->type = $type;
        $this->abstract = $abstract;
        $this->collection = $collection;
        $this->query = $query;
        $this->single = $single;
        $this->plural = $plural;
        $this->entity = $entity;
        $this->template = $template;
    }

    public function getModelInterfacePrinter(): ModelCollectionInterfacePrinter
    {
        return new ModelCollectionInterfacePrinter(
            $this->model,
            $this->single,
            $this->plural,
            $this->contracts,
            $this->type
        );
    }

    public function getAbstractCollectionPrinter(): ModelCollectionAbstractPrinter
    {
        return new ModelCollectionAbstractPrinter(
            $this->model,
            $this->single,
            $this->plural,
            $this->abstracts,
            $this->abstract,
            $this->getContractFqn(),
        );
    }

    public function getChildQueryPrinter(): ModelQueryAsChildPrinter
    {
        return new ModelQueryAsChildPrinter(
            $this->getAbstractFqn(),
            $this->model,
            $this->single,
            $this->plural,
            $this->namespace,
            $this->query,
            $this->getContractFqn(),
            $this->entity,
            $this->template
        );
    }

    public function getChildCollectionPrinter(): ModelCollectionAsChildPrinter
    {
        return new ModelCollectionAsChildPrinter(
            $this->getAbstractFqn(),
            $this->model,
            $this->single,
            $this->plural,
            $this->namespace,
            $this->collection,
            $this->getContractFqn(),
        );
    }

    protected function getAbstractFqn(): string
    {
        return $this->abstracts . '\\' . $this->abstract;
    }

    protected function getContractFqn(): string
    {
        return $this->contracts . '\\' . $this->type;
    }

    public static function build(array $args = []): ModelCollectionsFactory
    {
        $single = $args['single'] ?? $args['entity'];

        return new static(
            $args['model'],
            $args['namespace'],
            $args['contracts'],
            $args['abstracts'],
            $args['type'],
            $args['abstract'],
            $args['collection'],
            $args['query'],
            $args['entity'],
            $single,
            $args['plural'] ?? $single,
            $args['template'] ?? 'post'
        );
    }
}
