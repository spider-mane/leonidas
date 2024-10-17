<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Closure;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfiguration;

class PostType extends AbstractModelConfiguration implements PostTypeInterface
{
    protected null|array $taxonomies;

    protected null|string|array $capabilityType;

    protected ?bool $isDeletedWithUser;

    protected ?bool $allowsMetaCapMapping;

    protected ?bool $canBeExported;

    /**
     * @var null|callable
     */
    protected null|string|array|Closure $registerMetaBoxCb;

    protected null|string|bool $autosaveRestControllerClass;

    protected null|string|bool $revisionsRestControllerClass;

    protected ?bool $allowsLateRouteRegistration;

    protected null|bool|string $archive;

    protected ?bool $isExcludedFromSearch;

    protected null|bool|string $displayedInMenu;

    protected ?int $menuPosition;

    protected ?string $menuIcon;

    protected null|bool|array $supports;

    protected ?bool $isAllowedInAdminBar;

    protected ?array $template;

    protected null|false|string $templateLock;

    public function __construct(
        string $name,
        string $pluralLabel,
        ?string $singularLabel = null,
        ?string $description = null,
        ?array $labels = null,
        ?bool $isPublic = null,
        ?bool $isHierarchical = null,
        ?bool $isPubliclyQueryable = null,
        ?bool $isAllowedInUi = null,
        null|bool|string $displayedInMenu = null,
        ?bool $isAllowedInNavMenus = null,
        ?array $capabilities = null,
        $rewrite = null,
        $queryVar = null,
        ?bool $isAllowedInRest = null,
        $restBase = null,
        $restNamespace = null,
        $restControllerClass = null,
        null|string|bool $autosaveRestControllerClass = null,
        null|string|bool $revisionsRestControllerClass = null,
        ?bool $allowsLateRouteRegistration = null,
        ?bool $isExcludedFromSearch = null,
        ?bool $isAllowedInAdminBar = null,
        ?int $menuPosition = null,
        ?string $menuIcon = null,
        $capabilityType = null,
        ?bool $allowsMetaCapMapping = null,
        $supports = null,
        ?callable $registerMetaBoxCb = null,
        ?array $taxonomies = null,
        $archive = null,
        ?bool $canBeExported = null,
        ?bool $isDeletedWithUser = null,
        ?array $template = null,
        $templateLock = null,
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
            $displayedInMenu,
            $capabilities,
            $rewrite,
            $queryVar,
            $isAllowedInRest,
            $restBase,
            $restNamespace,
            $restControllerClass,
            $options
        );

        // info
        $this->taxonomies = $taxonomies;

        // system
        $this->capabilityType = $capabilityType;
        $this->isDeletedWithUser = $isDeletedWithUser;
        $this->allowsMetaCapMapping = $allowsMetaCapMapping;
        $this->canBeExported = $canBeExported;

        // public
        $this->archive = $archive;
        $this->isExcludedFromSearch = $isExcludedFromSearch;

        // REST
        $this->autosaveRestControllerClass = $autosaveRestControllerClass;
        $this->revisionsRestControllerClass = $revisionsRestControllerClass;
        $this->allowsLateRouteRegistration = $allowsLateRouteRegistration;

        // admin
        $this->menuPosition = $menuPosition;
        $this->menuIcon = $menuIcon;
        $this->supports = $supports;
        $this->displayedInMenu = $displayedInMenu;
        $this->registerMetaBoxCb = $registerMetaBoxCb;
        $this->isAllowedInAdminBar = $isAllowedInAdminBar;
        $this->isAllowedInNavMenus = $isAllowedInNavMenus;

        // editor
        $this->template = $template;
        $this->templateLock = $templateLock;
    }

    public function getTaxonomies(): ?array
    {
        return $this->taxonomies;
    }

    public function getCapabilityType(): null|string|array
    {
        return $this->capabilityType;
    }

    public function allowsMetaCapMapping(): ?bool
    {
        return $this->allowsMetaCapMapping;
    }

    public function canBeExported(): ?bool
    {
        return $this->canBeExported;
    }

    public function isDeletedWithUser(): ?bool
    {
        return $this->isDeletedWithUser;
    }

    public function getArchive(): null|bool|string
    {
        return $this->archive;
    }

    public function isExcludedFromSearch(): ?bool
    {
        return $this->isExcludedFromSearch;
    }

    public function getAutosaveRestControllerClass(): null|string|bool
    {
        return $this->autosaveRestControllerClass;
    }

    public function getRevisionsRestControllerClass(): null|string|bool
    {
        return $this->revisionsRestControllerClass;
    }

    public function allowsLateRouteRegistration(): ?bool
    {
        return $this->allowsLateRouteRegistration;
    }

    public function getDisplayedInMenu(): null|bool|string
    {
        return $this->displayedInMenu;
    }

    public function getMenuPosition(): ?int
    {
        return $this->menuPosition;
    }

    public function getMenuIcon(): ?string
    {
        return $this->menuIcon;
    }

    public function isAllowedInAdminBar(): ?bool
    {
        return $this->isAllowedInAdminBar;
    }

    public function getSupports(): null|array|bool
    {
        return $this->supports;
    }

    public function getRegisterMetaBoxCb(): ?callable
    {
        return $this->registerMetaBoxCb;
    }

    public function getTemplate(): ?array
    {
        return $this->template;
    }

    public function getTemplateLock(): null|false|string
    {
        return $this->templateLock;
    }

    protected function defaultLabels(): array
    {
        $singleUpper = $this->getSingularLabel();
        $pluralUpper = $this->getPluralLabel();
        $singleLower = strtolower($singleUpper);
        $pluralLower = strtolower($pluralUpper);

        return [
            'name' => $pluralUpper,
            'singular_name' => $singleUpper,
            'add_new' => "Add New {$singleUpper}",
            'add_new_item' => "Add New {$singleUpper}",
            'edit_item' => "Edit {$singleUpper}",
            'new_item' => "New {$singleUpper}",
            'view_item' => "View {$singleUpper}",
            'view_items' => "View {$pluralUpper}",
            'search_items' => "Search {$pluralUpper}",
            'not_found' => "No {$pluralLower} found",
            'not_found_in_trash' => "No {$pluralLower} found in Trash",
            'parent_item_colon' => "Parent {$singleUpper}:",
            'all_items' => "All {$pluralUpper}",
            'archives' => "{$singleUpper} Archives",
            'attributes' => "{$singleUpper} Attributes",
            'insert_into_item' => "Insert into {$singleLower}",
            'uploaded_to_this_item' => "Uploaded to this {$singleLower}",
            'filter_items_list' => "Filter {$pluralLower} list",
            'items_list_navigation' => "{$pluralUpper} list navigation",
            'items_list' => "{$pluralUpper} list",
            'item_published' => "{$singleUpper} published",
            'item_published_privately' => "{$singleUpper} published privately",
            'item_reverted_to_draft' => "{$singleUpper} reverted to draft",
            'item_scheduled' => "{$singleUpper} scheduled",
            'item_updated' => "{$singleUpper} updated",
            'item_link' => "{$singleUpper} Link",
            'item_link_description' => "A link to a {$singleLower}.",
        ];
    }
}
