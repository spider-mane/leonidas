<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractSystemModelType;

class PostType extends AbstractSystemModelType implements PostTypeInterface
{
    protected bool $isExcludedFromSearch;

    protected bool $isAllowedInAdminBar;

    protected ?int $menuPosition;

    protected ?string $menuIcon;

    /**
     * @var string|array
     */
    protected $capabilityType;

    protected bool $allowsMetaCapMapping;

    /**
     * @var bool|array
     */
    protected $supports;

    /**
     * @var null|callable
     */
    protected $registerMetaBoxCb;

    protected array $taxonomies;

    /**
     * @var bool|string
     */
    protected $archive;

    protected bool $canBeExported;

    protected ?bool $isDeletedWithUser;

    protected array $template;

    /**
     * @var false|string
     */
    protected $templateLock;

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
        ?bool $isExcludedFromSearch = null,
        ?bool $isAllowedInAdminBar = null,
        ?int $menuPosition = null,
        ?string $menuIcon = null,
        $capabilityType = 'post',
        bool $allowsMetaCapMapping = false,
        $supports = [],
        ?callable $registerMetaBoxCb = null,
        array $taxonomies = [],
        $archive = false,
        bool $canBeExported = true,
        ?bool $isDeletedWithUser = null,
        array $template = [],
        $templateLock = false,
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

        // model
        $this->taxonomies = $taxonomies;

        // system
        $this->capabilityType = $capabilityType;
        $this->canBeExported = $canBeExported;
        $this->isDeletedWithUser = $isDeletedWithUser;
        $this->allowsMetaCapMapping = $allowsMetaCapMapping;

        // public
        $this->archive = $archive;
        $this->isExcludedFromSearch = $isExcludedFromSearch ?? !$this->isPublic;

        // admin
        $this->menuPosition = $menuPosition;
        $this->menuIcon = $menuIcon;
        $this->supports = $supports;
        $this->registerMetaBoxCb = $registerMetaBoxCb;
        $this->isAllowedInAdminBar = $isAllowedInAdminBar ?? $this->displayedInMenu;

        // editor
        $this->template = $template;
        $this->templateLock = $templateLock;
    }

    public function isExcludedFromSearch(): bool
    {
        return $this->isExcludedFromSearch;
    }

    public function isAllowedInAdminBar(): bool
    {
        return $this->isAllowedInAdminBar;
    }

    public function getMenuPosition(): ?int
    {
        return $this->menuPosition;
    }

    public function getMenuIcon(): ?string
    {
        return $this->menuIcon;
    }

    public function getCapabilityType()
    {
        return $this->capabilityType;
    }

    public function allowsMetaCapMapping(): bool
    {
        return $this->allowsMetaCapMapping;
    }

    public function getSupports()
    {
        return $this->supports;
    }

    public function getRegisterMetaBoxCb(): ?callable
    {
        return $this->registerMetaBoxCb;
    }

    public function getTaxonomies(): array
    {
        return $this->taxonomies;
    }

    public function getArchive()
    {
        return $this->archive;
    }

    public function canBeExported(): bool
    {
        return $this->canBeExported;
    }

    public function isDeletedWithUser(): ?bool
    {
        return $this->isDeletedWithUser;
    }

    public function getTemplate(): array
    {
        return $this->template;
    }

    public function getTemplateLock()
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
