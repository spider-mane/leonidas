<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Closure;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfiguration;

class Taxonomy extends AbstractModelConfiguration implements TaxonomyInterface
{
    protected ?array $objectTypes;

    protected null|string|array $defaultTerm;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $updateCountCallback;

    protected ?bool $shouldBeSorted;

    protected ?array $args;

    protected ?bool $allowedInMenu;

    protected ?bool $isAllowedInTagCloud;

    protected ?bool $canHaveAdminColumn;

    protected ?bool $isAllowedInQuickEdit;

    /**
     * @var null|bool|callable
     */
    protected null|bool|string|array|Closure $metaBoxCb;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $metaBoxSanitizeCb;

    public function __construct(
        string $name,
        array $objectTypes,
        string $pluralLabel,
        ?string $singularLabel = null,
        string $description = '',
        array $labels = [],
        bool $isPublic = null,
        bool $isHierarchical = null,
        ?bool $isPubliclyQueryable = null,
        ?bool $isAllowedInUi = null,
        $allowedInMenu = null,
        ?bool $isAllowedInNavMenus = null,
        array $capabilities = [],
        $rewrite = true,
        $queryVar = true,
        bool $isAllowedInRest = null,
        $restBase = null,
        $restNamespace = null,
        $restControllerClass = null,
        ?bool $isAllowedInTagCloud = null,
        ?bool $isAllowedInQuickEdit = null,
        bool $canHaveAdminColumn = null,
        $metaBoxCb = null,
        ?callable $metaBoxSanitizeCb = null,
        ?callable $updateCountCallback = null,
        $defaultTerm = null,
        $shouldBeSorted = null,
        ?array $options = null
    ) {
        parent::__construct(
            $name,
            $pluralLabel,
            $singularLabel,
            $description,
            $labels,
            $isPublic,
            $isHierarchical,
            $isPubliclyQueryable,
            $isAllowedInUi,
            $isAllowedInNavMenus,
            $capabilities,
            $rewrite,
            $queryVar,
            $isAllowedInRest,
            $restBase,
            $restNamespace,
            $restControllerClass,
            $options
        );

        // system
        $this->objectTypes = $objectTypes;
        $this->updateCountCallback = $updateCountCallback;
        $this->defaultTerm = $defaultTerm;
        $this->shouldBeSorted = $shouldBeSorted;

        // public
        $this->isAllowedInTagCloud = $isAllowedInTagCloud ?? $this->isAllowedInUi;

        // admin
        $this->allowedInMenu = $allowedInMenu;
        $this->canHaveAdminColumn = $canHaveAdminColumn;
        $this->metaBoxCb = $metaBoxCb;
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;
        $this->isAllowedInQuickEdit = $isAllowedInQuickEdit ?? $this->isAllowedInUi;
    }

    public function getObjectTypes(): ?array
    {
        return $this->objectTypes;
    }

    public function getDefaultTerm(): null|string|array
    {
        return $this->defaultTerm;
    }

    public function getUpdateCountCallback(): ?callable
    {
        return $this->updateCountCallback;
    }

    public function shouldBeSorted(): ?bool
    {
        return $this->shouldBeSorted;
    }

    public function getArgs(): ?array
    {
        return $this->args;
    }

    public function isAllowedInTagCloud(): ?bool
    {
        return $this->isAllowedInTagCloud;
    }

    public function isAllowedInMenu(): ?bool
    {
        return $this->allowedInMenu;
    }

    public function canHaveAdminColumn(): ?bool
    {
        return $this->canHaveAdminColumn;
    }

    public function isAllowedInQuickEdit(): ?bool
    {
        return $this->isAllowedInQuickEdit;
    }

    public function getMetaBoxCb(): null|bool|callable
    {
        return $this->metaBoxCb;
    }

    public function getMetaBoxSanitizeCb(): ?callable
    {
        return $this->metaBoxSanitizeCb;
    }

    protected function defaultLabels(): array
    {
        $singleUpper = $this->getSingularLabel();
        $pluralUpper = $this->getPluralLabel();
        $pluralLower = strtolower($pluralUpper);

        return [
            'name' => $pluralUpper,
            'singular_name' => $singleUpper,
            'search_items' => "Search {$pluralUpper}",
            'popular_items' => "Popular {$pluralUpper}",
            'all_items' => "All {$pluralUpper}",
            'parent_item' => "Parent {$singleUpper}",
            'parent_item_colon' => "Parent {$singleUpper}:",
            'edit_item' => "Edit {$singleUpper}",
            'view_item' => "View {$singleUpper}",
            'update_item' => "Update {$pluralUpper}",
            'add_new_item' => "Add New {$singleUpper}",
            'new_item_name' => "New {$singleUpper} Name",
            'separate_items_with_commas' => "Separate {$pluralLower} with commas",
            'add_or_remove_items' => "Add or remove {$pluralLower}",
            'choose_from_most_used' => "Choose from the most used {$pluralLower}",
            'not_found' => "No {$pluralLower} found",
            'no_terms' => "No {$pluralLower}",
            'items_list_navigation' => "{$pluralUpper} list navigation",
            'items_list' => "{$pluralUpper} list",
            'back_to_items' => "&larr; Back to {$pluralUpper}",
        ];
    }
}
