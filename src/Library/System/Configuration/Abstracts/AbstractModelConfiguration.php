<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Configuration\ModelConfigurationInterface;

abstract class AbstractModelConfiguration implements ModelConfigurationInterface
{
    protected string $name;

    protected string $pluralLabel;

    protected string $singularLabel;

    protected string $description;

    protected ?array $labels;

    protected ?bool $isPublic;

    protected ?bool $isHierarchical;

    protected ?bool $isPubliclyQueryable;

    protected ?bool $isAllowedInUi;

    protected ?bool $isAllowedInNavMenus;

    protected ?array $capabilities;

    protected null|bool|array $rewrite;

    protected null|bool|string $queryVar;

    protected ?bool $isAllowedInRest;

    protected null|bool|string $restBase;

    protected null|bool|string $restNamespace;

    protected null|bool|string $restControllerClass;

    protected array $extra;

    public function __construct(
        string $name,
        string $pluralLabel,
        ?string $singularLabel = null,
        string $description = null,
        array $labels = null,
        bool $isPublic = null,
        bool $isHierarchical = null,
        ?bool $isPubliclyQueryable = null,
        ?bool $isAllowedInUi = null,
        ?bool $isAllowedInNavMenus = null,
        array $capabilities = null,
        null|bool|array $rewrite = null,
        null|bool|string $queryVar = null,
        bool $isAllowedInRest = null,
        null|bool|string $restBase = null,
        null|bool|string $restNamespace = null,
        null|bool|string $restControllerClass = null,
        ?array $extra = null
    ) {
        // info
        $this->name = $name;
        $this->pluralLabel = $pluralLabel;
        $this->singularLabel = $singularLabel ?? $this->pluralLabel;
        $this->description = $description ?? '';

        // core
        $this->isHierarchical = $isHierarchical;
        $this->capabilities = $capabilities;

        // REST
        $this->isAllowedInRest = $isAllowedInRest;
        $this->restBase = $restBase;
        $this->restNamespace = $restNamespace;
        $this->restControllerClass = $restControllerClass;

        // public
        $this->isPublic = $isPublic;
        $this->isPubliclyQueryable = $isPubliclyQueryable;
        $this->queryVar = $queryVar;
        $this->isAllowedInNavMenus = $isAllowedInNavMenus;
        $this->rewrite = $rewrite;

        // admin
        $this->isAllowedInUi = $isAllowedInUi;
        $this->labels = ($labels ?? []) + $this->defaultLabels();

        // misc
        $this->extra = $extra ?? [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPluralLabel(): string
    {
        return $this->pluralLabel;
    }

    public function getSingularLabel(): string
    {
        return $this->singularLabel;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLabels(): ?array
    {
        return $this->labels;
    }

    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function isHierarchical(): ?bool
    {
        return $this->isHierarchical;
    }

    public function isPubliclyQueryable(): ?bool
    {
        return $this->isPubliclyQueryable;
    }

    public function isAllowedInUi(): ?bool
    {
        return $this->isAllowedInUi;
    }

    public function isAllowedInNavMenus(): ?bool
    {
        return $this->isAllowedInNavMenus;
    }

    public function getRewrite(): null|bool|array
    {
        return $this->rewrite;
    }

    public function getQueryVar(): null|bool|string
    {
        return $this->queryVar;
    }

    public function isAllowedInRest(): ?bool
    {
        return $this->isAllowedInRest;
    }

    public function getRestBase(): null|bool|string
    {
        return $this->restBase;
    }

    public function getRestNamespace(): null|bool|string
    {
        return $this->restNamespace;
    }

    public function getRestControllerClass(): null|bool|string
    {
        return $this->restControllerClass;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }

    abstract protected function defaultLabels(): array;
}
