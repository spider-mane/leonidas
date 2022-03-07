<?php

namespace Leonidas\Library\System\Taxonomy;

use Leonidas\Contracts\System\Taxonomy\TaxonomyInterface;
use Leonidas\Library\System\AbstractSystemModelType;

class Taxonomy extends AbstractSystemModelType implements TaxonomyInterface
{
    protected array $objectTypes;

    protected bool $isShownInTagCloud;

    protected bool $isShownInQuickEdit;

    protected bool $showsAdminColumn;

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
        ?bool $isShownInTagCloud = null,
        ?bool $isShownInQuickEdit = null,
        bool $showsAdminColumn = false,
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
            $isShownInUi,
            $shownInMenu,
            $isShownInNavMenus,
            $capabilities,
            $rewrite,
            $queryVar,
            $isShownInRest,
            $restBase,
            $restNamespace,
            $restControllerClass,
            $options
        );

        $this->objectTypes = $objectTypes;
        $this->showsAdminColumn = $showsAdminColumn;
        $this->metaBoxCb = $metaBoxCb;
        $this->metaBoxSanitizeCb = $metaBoxSanitizeCb;
        $this->updateCountCallback = $updateCountCallback;
        $this->defaultTerm = $defaultTerm;
        $this->shouldBeSorted = $shouldBeSorted;

        $this->isShownInTagCloud = $isShownInTagCloud ?? $this->isShownInUi;
        $this->isShownInQuickEdit = $isShownInQuickEdit ?? $this->isShownInUi;
    }

    public function getObjectTypes(): array
    {
        return $this->objectTypes;
    }

    public function isShownInTagCloud(): bool
    {
        return $this->isShownInTagCloud;
    }

    public function isShownInQuickEdit(): bool
    {
        return $this->isShownInQuickEdit;
    }

    public function showsAdminColumn(): bool
    {
        return $this->showsAdminColumn;
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
