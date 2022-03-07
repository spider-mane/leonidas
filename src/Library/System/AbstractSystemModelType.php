<?php

namespace Leonidas\Library\System;

use Leonidas\Contracts\System\BaseSystemModelTypeInterface;

abstract class AbstractSystemModelType implements BaseSystemModelTypeInterface
{
    protected string $name;

    protected string $singularLabel;

    protected string $pluralLabel;

    protected string $description;

    protected array $labels;

    protected bool $isPublic;

    protected bool $isHierarchical;

    protected bool $isPubliclyQueryable;

    protected bool $isShownInUi;

    /**
     * @var bool|string
     */
    protected $shownInMenu;

    protected bool $isShownInNavMenus;

    protected array $capabilities;

    /**
     * @var bool|array
     */
    protected $rewrite;

    /**
     * @var bool|string
     */
    protected $queryVar;

    protected bool $isShownInRest;

    /**
     * @var bool|string
     */
    protected $restBase;

    /**
     * @var bool|string
     */
    protected $restNamespace;

    /**
     * @var bool|string
     */
    protected $restControllerClass;

    protected array $options;

    public function __construct(
        string $name,
        string $pluralLabel,
        string $singularLabel,
        string $description = '',
        array $labels = [],
        bool $isPublic = false,
        bool $isHierarchical = false,
        ?bool $isPubliclyQueryable = null,
        ?bool $isShownInUi = null,
        $shownInMenu = null,
        ?bool $isShownInNavMenus = null,
        array $capabilities = [],
        $rewrite = true,
        $queryVar = true,
        bool $isShownInRest = false,
        $restBase = false,
        $restNamespace = false,
        $restControllerClass = false,
        array $options = []
    ) {
        $this->name = $name;
        $this->pluralLabel = $pluralLabel;
        $this->description = $description;
        $this->labels = $labels + $this->defaultLabels();
        $this->isPublic = $isPublic;
        $this->isHierarchical = $isHierarchical;
        $this->capabilities = $capabilities;
        $this->rewrite = $rewrite;
        $this->queryVar = $queryVar;
        $this->isShownInRest = $isShownInRest;
        $this->restBase = $restBase;
        $this->restNamespace = $restNamespace;
        $this->restControllerClass = $restControllerClass;
        $this->options = $options;

        $this->singularLabel = $singularLabel ?? $this->pluralLabel;
        $this->isPubliclyQueryable = $isPubliclyQueryable ?? $this->isPublic;
        $this->isShownInUi = $isShownInUi ?? $this->isPublic;
        $this->shownInMenu = $shownInMenu ?? $this->isShownInUi;
        $this->isShownInNavMenus = $isShownInNavMenus ?? $this->isPublic;
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

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function isHierarchical(): bool
    {
        return $this->isHierarchical;
    }

    public function isPubliclyQueryable(): bool
    {
        return $this->isPubliclyQueryable;
    }

    public function isShownInUi(): bool
    {
        return $this->isShownInUi;
    }

    public function getShownInMenu()
    {
        return $this->shownInMenu;
    }

    public function isShownInNavMenus(): bool
    {
        return $this->isShownInNavMenus;
    }

    public function getRewrite()
    {
        return $this->rewrite;
    }

    public function getQueryVar()
    {
        return $this->queryVar;
    }

    public function isShownInRest(): bool
    {
        return $this->isShownInRest;
    }

    public function getRestBase()
    {
        return $this->restBase;
    }

    public function getRestNamespace()
    {
        return $this->restNamespace;
    }

    public function getRestControllerClass()
    {
        return $this->restControllerClass;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    abstract protected function defaultLabels(): array;
}
