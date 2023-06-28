<?php

namespace Leonidas\Library\System\Configuration\Abstracts;

use Leonidas\Contracts\System\Model\BaseSystemModelTypeInterface;

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

    protected bool $isAllowedInUi;

    /**
     * @var bool|string
     */
    protected $displayedInMenu;

    protected bool $isAllowedInNavMenus;

    protected array $capabilities;

    /**
     * @var bool|array
     */
    protected $rewrite;

    /**
     * @var bool|string
     */
    protected $queryVar;

    protected bool $isAllowedInRest;

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
        ?string $singularLabel = null,
        string $description = '',
        array $labels = [],
        bool $isPublic = false,
        bool $isHierarchical = false,
        ?bool $isPubliclyQueryable = null,
        ?bool $isAllowedInUi = null,
        $displayedInMenu = null,
        ?bool $isAllowedInNavMenus = null,
        array $capabilities = [],
        $rewrite = true,
        $queryVar = true,
        bool $isAllowedInRest = false,
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
        $this->isAllowedInRest = $isAllowedInRest;
        $this->restBase = $restBase;
        $this->restNamespace = $restNamespace;
        $this->restControllerClass = $restControllerClass;
        $this->options = $options;

        $this->singularLabel = $singularLabel ?? $this->pluralLabel;
        $this->isPubliclyQueryable = $isPubliclyQueryable ?? $this->isPublic;
        $this->isAllowedInUi = $isAllowedInUi ?? $this->isPublic;
        $this->displayedInMenu = $displayedInMenu ?? $this->isAllowedInUi;
        $this->isAllowedInNavMenus = $isAllowedInNavMenus ?? $this->isPublic;
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

    public function isAllowedInUi(): bool
    {
        return $this->isAllowedInUi;
    }

    public function getDisplayedInMenu()
    {
        return $this->displayedInMenu;
    }

    public function isAllowedInNavMenus(): bool
    {
        return $this->isAllowedInNavMenus;
    }

    public function getRewrite()
    {
        return $this->rewrite;
    }

    public function getQueryVar()
    {
        return $this->queryVar;
    }

    public function isAllowedInRest(): bool
    {
        return $this->isAllowedInRest;
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
