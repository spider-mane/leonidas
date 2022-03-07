<?php

namespace Leonidas\Library\System\Taxonomy;

use Leonidas\Contracts\System\Taxonomy\TaxonomyBuilderInterface;
use Leonidas\Library\System\AbstractSystemModelTypeBuilder;

class TaxonomyBuilder extends AbstractSystemModelTypeBuilder implements TaxonomyBuilderInterface
{
    protected array $objectTypes;

    protected ?bool $isShownInTagCloud;

    protected ?bool $isShownInQuickEdit;

    protected ?bool $showsAdminColumn;

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

    protected ?bool $shouldBeSorted;

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

    public function hierarchical(?bool $isHierarchical): self
    {
        $this->isHierarchical = $isHierarchical;

        return $this;
    }

    public function publiclyQueryable(?bool $isPubliclyQueryable): self
    {
        $this->isPubliclyQueryable = $isPubliclyQueryable;

        return $this;
    }

    public function showInUi(?bool $showInUi): self
    {
        $this->isShownInUi = $showInUi;

        return $this;
    }

    public function showInMenu($showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function showInNavMenus(?bool $showInNavMenu): self
    {
        $this->shownInMenus = $showInNavMenu;

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
        $this->isShownInRest = $showInRest;

        return $this;
    }

    public function restBase(?string $restBase): self
    {
        $this->restBase = $restBase;

        return $this;
    }

    public function restNamespace(?string $restNamespace): self
    {
        $this->restNamespace = $restNamespace;

        return $this;
    }

    public function restControllerClass(?string $restControllerClass): self
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
        $this->isShownInTagCloud = $showInTagCloud;

        return $this;
    }

    public function showInQuickEdit(?bool $showInQuickEdit): self
    {
        $this->isShownInQuickEdit = $showInQuickEdit;

        return $this;
    }

    public function showAdminColumn(?bool $showAdminColumn): self
    {
        $this->showsAdminColumn = $showAdminColumn;

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
            $this->isHierarchical ?? false,
            $this->isPubliclyQueryable,
            $this->isShownInUi,
            $this->shownInMenus,
            $this->isShownInNavMenus,
            $this->capabilities ?? [],
            $this->rewrite ?? true,
            $this->queryVar ?? true,
            $this->isShownInRest ?? false,
            $this->restBase ?? false,
            $this->restNamespace ?? false,
            $this->restControllerClass ?? false,
            $this->isShownInTagCloud,
            $this->isShownInQuickEdit,
            $this->showsAdminColumn ?? false,
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
