<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractSystemModelType;

class Taxonomy extends AbstractSystemModelType implements TaxonomyInterface
{
    protected array $objectTypes;

    protected bool $isAllowedInTagCloud;

    protected bool $isAllowedInQuickEdit;

    protected bool $canHaveAdminColumn;

    /**
     * @var bool|callable
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

    protected bool $shouldBeSorted;

    /**
     * @return null|array
     */
    protected $args;

    public function __construct(
        string $name,
        array $objectTypes,
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
        ?bool $isAllowedInTagCloud = null,
        ?bool $isAllowedInQuickEdit = null,
        bool $canHaveAdminColumn = false,
        $metaBoxCb = null,
        ?callable $metaBoxSanitizeCb = null,
        ?callable $updateCountCallback = null,
        $defaultTerm = null,
        $shouldBeSorted = null,
        array $options = []
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
            $displayedInMenu,
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

        $this->objectTypes = $objectTypes;
        $this->canHaveAdminColumn = $canHaveAdminColumn;
        $this->metaBoxCb = $metaBoxCb;
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;
        $this->updateCountCallback = $updateCountCallback;
        $this->defaultTerm = $defaultTerm;
        $this->shouldBeSorted = $shouldBeSorted;

        $this->isAllowedInTagCloud = $isAllowedInTagCloud ?? $this->isAllowedInUi;
        $this->isAllowedInQuickEdit = $isAllowedInQuickEdit ?? $this->isAllowedInUi;
    }

    public function getObjectTypes(): array
    {
        return $this->objectTypes;
    }

    public function isAllowedInTagCloud(): bool
    {
        return $this->isAllowedInTagCloud;
    }

    public function isAllowedInQuickEdit(): bool
    {
        return $this->isAllowedInQuickEdit;
    }

    public function canHaveAdminColumn(): bool
    {
        return $this->canHaveAdminColumn;
    }

    public function getMetaBoxCb()
    {
        return $this->metaBoxCb;
    }

    public function getMetaBoxSanitizeCb(): ?callable
    {
        return $this->metaBoxSanitizeCb;
    }

    public function getUpdateCountCallback(): ?callable
    {
        return $this->updateCountCallback;
    }

    public function getDefaultTerm()
    {
        return $this->defaultTerm;
    }

    public function shouldBeSorted(): bool
    {
        return $this->shouldBeSorted;
    }

    public function getArgs(): array
    {
        return $this->args;
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
