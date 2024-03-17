<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyBuilderInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractSystemModelTypeBuilder;

class TaxonomyBuilder extends AbstractSystemModelTypeBuilder implements TaxonomyBuilderInterface
{
    protected array $objectTypes = [];

    protected ?bool $showTagCloud = null;

    protected ?bool $showInQuickEdit = null;

    protected ?bool $showAdminColumn = null;

    protected ?bool $showInMenu = null;

    /**
     * @var null|bool|callable
     */
    protected $metaBoxCb;

    /**
     * @var null|callable
     */
    protected $metaBoxSanitizeCb;

    /**
     * @var null|callable
     */
    protected $updateCountCallback;

    /**
     * @var null|string|array
     */
    protected $defaultTerm;

    protected ?bool $shouldBeSorted = null;

    /**
     * @return null|array
     */
    protected $args;

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function plural(string $pluralLabel): self
    {
        $this->pluralLabel = $pluralLabel;

        return $this;
    }

    public function singular(?string $singularLabel): self
    {
        $this->singularLabel = $singularLabel;

        return $this;
    }

    public function description(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function labels(?array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    public function public(?bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function hierarchical(?bool $hierarchical): self
    {
        $this->hierarchical = $hierarchical;

        return $this;
    }

    public function publiclyQueryable(?bool $publiclyQueryable): self
    {
        $this->publiclyQueryable = $publiclyQueryable;

        return $this;
    }

    public function showInUi(?bool $showInUi): self
    {
        $this->isAllowedInUi = $showInUi;

        return $this;
    }

    public function showInMenu($showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function showInNavMenus(?bool $showInNavMenu): self
    {
        $this->displayedInMenu = $showInNavMenu;

        return $this;
    }

    public function capabilities(?array $capabilities): self
    {
        $this->capabilities = $capabilities;

        return $this;
    }

    public function rewrite($rewrite): self
    {
        $this->rewrite = $rewrite;

        return $this;
    }

    public function queryVar($queryVar): self
    {
        $this->queryVar = $queryVar;

        return $this;
    }

    public function showInRest(?bool $showInRest): self
    {
        $this->isAllowedInRest = $showInRest;

        return $this;
    }

    public function restBase($restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    public function restNamespace($restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    public function restControllerClass($restControllerClass): self
    {
        $this->restControllerClass = $restControllerClass;

        return $this;
    }

    public function options(?array $extraArgs): self
    {
        $this->options = $extraArgs;

        return $this;
    }

    public function objectTypes(string ...$objectTypes): self
    {
        $this->objectTypes = $objectTypes;

        return $this;
    }

    public function showTagCloud(?bool $showInTagCloud): self
    {
        $this->showTagCloud = $showInTagCloud;

        return $this;
    }

    public function showInQuickEdit(?bool $showInQuickEdit): self
    {
        $this->showInQuickEdit = $showInQuickEdit;

        return $this;
    }

    public function showAdminColumn(?bool $showAdminColumn): self
    {
        $this->showAdminColumn = $showAdminColumn;

        return $this;
    }

    public function metaBoxCb($metaBoxCb): self
    {
        $this->metaBoxCb = $metaBoxCb;

        return $this;
    }

    public function metaBoxSanitizeCb(?callable $metaBoxSanitizeCb): self
    {
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;

        return $this;
    }

    public function updateCountCallback(?callable $updateCountCallback): self
    {
        $this->updateCountCallback = $updateCountCallback;

        return $this;
    }

    public function defaultTerm($defaultTerm): self
    {
        $this->defaultTerm = $defaultTerm;

        return $this;
    }

    public function sort(?bool $sorted): self
    {
        $this->shouldBeSorted = $sorted;

        return $this;
    }

    public function args(?array $args): self
    {
        $this->args = $args;

        return $this;
    }

    public function get(): Taxonomy
    {
        return new Taxonomy(
            $this->name,
            $this->objectTypes,
            $this->pluralLabel,
            $this->singularLabel,
            $this->description ?? '',
            $this->labels ?? [],
            $this->isPublic ?? false,
            $this->hierarchical ?? false,
            $this->publiclyQueryable,
            $this->isAllowedInUi,
            $this->displayedInMenu,
            $this->isAllowedInNavMenus,
            $this->capabilities ?? [],
            $this->rewrite ?? true,
            $this->queryVar ?? true,
            $this->isAllowedInRest ?? false,
            $this->restBase ?? false,
            $this->restNamespace ?? false,
            $this->restControllerClass ?? false,
            $this->showTagCloud,
            $this->showInQuickEdit,
            $this->showAdminColumn ?? false,
            $this->metaBoxCb,
            $this->metaBoxSanitizeCb,
            $this->updateCountCallback,
            $this->defaultTerm,
            $this->shouldBeSorted,
            $this->options ?? []
        );
    }

    public static function for(string $name): self
    {
        return new self($name);
    }
}
