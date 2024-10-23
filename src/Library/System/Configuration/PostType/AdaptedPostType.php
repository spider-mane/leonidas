<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use WP_Post_Type;

class AdaptedPostType implements PostTypeInterface
{
    public function __construct(
        protected WP_Post_Type $postType,
        protected array $options = []
    ) {
        //
    }

    public function getName(): string
    {
        return $this->postType->name;
    }

    public function getLabel(): string
    {
        return $this->postType->label;
    }

    public function getDescription(): string
    {
        return $this->postType->description;
    }

    public function isPublic(): bool
    {
        return $this->postType->public;
    }

    public function getPubliclyQueryable(): bool
    {
        return $this->postType->publicly_queryable;
    }

    public function getShowUi(): bool
    {
        return $this->postType->show_ui;
    }

    public function getShowInMenu(): bool
    {
        return $this->postType->show_in_menu;
    }

    public function getMenuPosition(): ?int
    {
        return $this->postType->menu_position;
    }

    public function getMenuIcon(): ?string
    {
        return $this->postType->menu_icon;
    }

    public function getCapabilityType(): string
    {
        return $this->postType->capability_type;
    }

    public function getSupports(): array
    {
        return $this->postType->supports;
    }

    public function getTaxonomies(): array
    {
        return $this->postType->taxonomies;
    }

    public function getArchive(): ?string
    {
        return $this->postType->has_archive;
    }

    public function canBeExported(): bool
    {
        return $this->postType->can_export;
    }

    public function isDeletedWithUser(): ?bool
    {
        return $this->postType->delete_with_user;
    }

    public function getTemplate(): array
    {
        return $this->postType->template;
    }

    public function getTemplateLock(): ?string
    {
        return $this->postType->template_lock;
    }

    public function isExcludedFromSearch(): bool
    {
        return $this->postType->exclude_from_search;
    }

    public function isAllowedInAdminBar(): bool
    {
        return $this->postType->show_in_admin_bar;
    }

    public function allowsMetaCapMapping(): bool
    {
        return $this->postType->map_meta_cap;
    }

    public function getRegisterMetaBoxCb(): ?callable
    {
        return $this->postType->register_meta_box_cb;
    }

    public function getRewrite(): array
    {
        return $this->postType->rewrite;
    }

    public function getQueryVar(): string
    {
        return $this->postType->query_var;
    }

    public function isAllowedInNavMenus(): bool
    {
        return $this->postType->show_in_nav_menus;
    }

    public function getRestBase(): string
    {
        return $this->postType->rest_base;
    }

    public function getRestControllerClass(): string
    {
        return $this->postType->rest_controller_class;
    }

    public function isAllowedInRest(): bool
    {
        return $this->postType->show_in_rest;
    }

    public function isAllowedInUi(): bool
    {
        return $this->postType->show_ui;
    }

    public function getLabels(): array
    {
        return (array) $this->postType->labels;
    }

    public function getSingularLabel(): string
    {
        return $this->postType->labels->singular_name;
    }

    public function getPluralLabel(): string
    {
        return $this->postType->labels->name;
    }

    public function getRestNamespace(): string
    {
        return $this->postType->rest_namespace;
    }

    public function getCapabilities(): array
    {
        return (array) $this->postType->cap;
    }

    public function getDisplayedInMenu()
    {
        return $this->postType->show_in_menu;
    }

    public function getExtra(): array
    {
        return $this->options;
    }

    public function isHierarchical(): bool
    {
        return $this->postType->hierarchical;
    }

    public function isPubliclyQueryable(): bool
    {
        return $this->postType->publicly_queryable;
    }

    public static function fromName(string $name): PostTypeInterface
    {
        return new static(get_post_type_object($name));
    }
}
