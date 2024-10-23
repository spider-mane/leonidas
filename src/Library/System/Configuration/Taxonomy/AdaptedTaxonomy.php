<?php

namespace Leonidas\Library\System\Configuration\Taxonomy;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use WP_Taxonomy;

class AdaptedTaxonomy implements TaxonomyInterface
{
    protected WP_Taxonomy $taxonomy;

    public function __construct(WP_Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    public function getName(): string
    {
        return $this->taxonomy->name;
    }

    public function getObjectTypes(): array
    {
        return $this->taxonomy->object_type;
    }

    public function getLabels(): array
    {
        return (array) $this->taxonomy->labels;
    }

    public function getPluralLabel(): string
    {
        return $this->taxonomy->labels->name;
    }

    public function getSingularLabel(): string
    {
        return $this->taxonomy->labels->singular_name;
    }

    public function getDescription(): string
    {
        return $this->taxonomy->description;
    }

    public function isHierarchical(): bool
    {
        return $this->taxonomy->hierarchical;
    }

    public function getRewrite(): array
    {
        return (array) $this->taxonomy->rewrite;
    }

    public function getQueryVar(): string
    {
        return $this->taxonomy->query_var;
    }

    public function getObjectType(): array
    {
        return (array) $this->taxonomy->object_type;
    }

    public function getShowUi(): bool
    {
        return $this->taxonomy->show_ui;
    }

    public function getShowInMenu(): bool
    {
        return $this->taxonomy->show_in_menu;
    }

    public function getShowInNavMenus(): bool
    {
        return $this->taxonomy->show_in_nav_menus;
    }

    public function getShowTagCloud(): bool
    {
        return $this->taxonomy->show_tagcloud;
    }

    public function getShowInQuickEdit(): bool
    {
        return $this->taxonomy->show_in_quick_edit;
    }

    public function getShowAdminColumn(): bool
    {
        return $this->taxonomy->show_admin_column;
    }

    public function getMetaBoxCallback(): ?callable
    {
        return $this->taxonomy->meta_box_cb;
    }

    public function getCapabilities(): array
    {
        return (array) $this->taxonomy->cap;
    }

    public function getRestBase(): string
    {
        return $this->taxonomy->rest_base;
    }

    public function getRestControllerClass(): string
    {
        return $this->taxonomy->rest_controller_class;
    }

    public function isAllowedInRest(): bool
    {
        return $this->taxonomy->show_in_rest;
    }

    public function isAllowedInNavMenus(): bool
    {
        return $this->taxonomy->show_in_nav_menus;
    }

    public function isAllowedInTagCloud(): bool
    {
        return $this->taxonomy->show_tagcloud;
    }

    public function isAllowedInQuickEdit(): bool
    {
        return $this->taxonomy->show_in_quick_edit;
    }

    public function canHaveAdminColumn(): bool
    {
        return $this->taxonomy->show_admin_column;
    }

    public function getMetaBoxCb(): ?callable
    {
        return $this->taxonomy->meta_box_cb;
    }

    public function getMetaBoxSanitizeCb(): ?callable
    {
        return $this->taxonomy->meta_box_sanitize_cb;
    }

    public function getUpdateCountCallback(): ?callable
    {
        return $this->taxonomy->update_count_callback;
    }

    public function getDefaultTerm(): ?string
    {
        return $this->taxonomy->default_term;
    }

    public function shouldBeSorted(): ?bool
    {
        return $this->taxonomy->sort;
    }

    public function getArgs(): ?array
    {
        return $this->taxonomy->args;
    }

    public function isAllowedInUi(): bool
    {
        return $this->taxonomy->show_ui;
    }

    public function isAllowedInAdmin(): bool
    {
        return $this->taxonomy->show_admin_column;
    }

    public function isAllowedInAdminMenu(): bool
    {
        return $this->taxonomy->show_in_menu;
    }

    public function isAllowedInAdminNavMenu(): bool
    {
        return $this->taxonomy->show_in_nav_menus;
    }

    public function isAllowedInAdminTagCloud(): bool
    {
        return $this->taxonomy->show_tagcloud;
    }

    public function isAllowedInAdminQuickEdit(): bool
    {
        return $this->taxonomy->show_in_quick_edit;
    }

    public function isAllowedInAdminUi(): bool
    {
        return $this->taxonomy->show_ui;
    }

    public function getDisplayedInMenu()
    {
        return $this->taxonomy->show_in_menu;
    }

    public function isPublic(): bool
    {
        return $this->taxonomy->public;
    }

    public function isPubliclyQueryable(): bool
    {
        return $this->taxonomy->publicly_queryable;
    }

    public function getRestNamespace()
    {
        return $this->taxonomy->rest_namespace;
    }

    public function getExtra(): array
    {
        return (array) $this->taxonomy->options ?? [];
    }

    public static function fromName(string $name): self
    {
        return new static(get_taxonomy($name));
    }
}
