<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Closure;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyBuilderInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationBuilder;

class TaxonomyBuilder extends AbstractModelConfigurationBuilder implements TaxonomyBuilderInterface
{
    protected ?array $objectTypes = [];

    protected null|string|array $defaultTerm = null;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $updateCountCallback = null;

    protected ?bool $shouldBeSorted = null;

    protected ?array $args = null;

    protected ?bool $showInTagCloud = null;

    protected ?bool $showInMenu = null;

    protected ?bool $showInQuickEdit = null;

    protected ?bool $showAdminColumn = null;

    /**
     * @var null|bool|callable
     */
    protected null|bool|string|array|Closure $metaBoxCb = null;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $metaBoxSanitizeCb = null;

    public function objectTypes(?array $objectTypes): static
    {
        $this->objectTypes = $objectTypes;

        return $this;
    }

    public function defaultTerm(null|string|array $defaultTerm): static
    {
        $this->defaultTerm = $defaultTerm;

        return $this;
    }

    public function updateCountCallback(?callable $updateCountCallback): static
    {
        $this->updateCountCallback = $updateCountCallback;

        return $this;
    }

    public function sort(?bool $sorted): static
    {
        $this->shouldBeSorted = $sorted;

        return $this;
    }

    public function args(?array $args): static
    {
        $this->args = $args;

        return $this;
    }

    public function showInTagCloud(?bool $showInTagCloud): static
    {
        $this->showInTagCloud = $showInTagCloud;

        return $this;
    }

    public function showInMenu(?bool $showInMenu): static
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function showInQuickEdit(?bool $showInQuickEdit): static
    {
        $this->showInQuickEdit = $showInQuickEdit;

        return $this;
    }

    public function showAdminColumn(?bool $showAdminColumn): static
    {
        $this->showAdminColumn = $showAdminColumn;

        return $this;
    }

    public function metaBoxCb(null|bool|callable $metaBoxCb): static
    {
        $this->metaBoxCb = $metaBoxCb;

        return $this;
    }

    public function metaBoxSanitizeCb(?callable $metaBoxSanitizeCb): static
    {
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;

        return $this;
    }

    public function get(): Taxonomy
    {
        return new Taxonomy(
            $this->name,
            $this->objectTypes,
            $this->pluralLabel,
            $this->singularLabel,
            $this->description,
            $this->labels,
            $this->isPublic,
            $this->hierarchical,
            $this->publiclyQueryable,
            $this->isAllowedInUi,
            $this->displayedInMenu,
            $this->isAllowedInNavMenus,
            $this->capabilities,
            $this->rewrite,
            $this->queryVar,
            $this->isAllowedInRest,
            $this->restBase,
            $this->restNamespace,
            $this->restControllerClass,
            $this->showInTagCloud,
            $this->showInQuickEdit,
            $this->showAdminColumn,
            $this->metaBoxCb,
            $this->metaBoxSanitizeCb,
            $this->updateCountCallback,
            $this->defaultTerm,
            $this->shouldBeSorted,
            $this->extra
        );
    }

    public static function for(string $name): static
    {
        return new static($name);
    }
}
