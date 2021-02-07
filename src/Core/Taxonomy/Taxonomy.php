<?php

namespace WebTheory\Leonidas\Core\Taxonomy;

use WebTheory\Leonidas\Core\AbstractWpObjectFacade;

class Taxonomy extends AbstractWpObjectFacade
{
    /**
     * @var string|array
     */
    protected $objectTypes;

    /**
     *
     */
    public function __construct(string $name, $objectTypes)
    {
        $this->name = $name;
        $this->objectTypes = $objectTypes;
    }

    /**
     * Get the value of objectTypes
     *
     * @return string|array
     */
    public function getObjectTypes()
    {
        return $this->objectTypes;
    }

    /**
     *
     */
    public function register()
    {
        register_taxonomy($this->name, $this->objectTypes, $this->buildArgs($this->args));

        $this->registerForObjectTypes();

        return $this;
    }

    /**
     * pair taxonomy to provided object types
     */
    protected function registerForObjectTypes()
    {
        foreach ((array) $this->objectTypes as $objectType) {
            register_taxonomy_for_object_type($this->name, $objectType);
        }

        return $this;
    }

    /**
     *
     */
    public function getRegisteredTaxonomy()
    {
        return get_taxonomy($this->name);
    }

    /**
     *
     */
    protected function getDefaultLabels(string $single, string $plural): array
    {
        $pluralLower = strtolower($plural);

        return [
            'name' => $plural,
            'singular_name' => $single,
            'search_items' => "Search {$plural}",
            'popular_items' => "Popular {$plural}",
            'all_items' => "All {$plural}",
            'parent_item' => "Parent {$single}",
            'parent_item_colon' => "Parent {$single}:",
            'edit_item' => "Edit {$single}",
            'view_item' => "View {$single}",
            'update_item' => "Update {$plural}",
            'add_new_item' => "Add New {$single}",
            'new_item_name' => "New {$single} Name",
            'separate_items_with_commas' => "Separate {$pluralLower} with commas",
            'add_or_remove_items' => "Add or remove {$pluralLower}",
            'choose_from_most_used' => "Choose from the most used {$pluralLower}",
            'not_found' => "No {$pluralLower} found",
            'no_terms' => "No {$pluralLower}",
            'items_list_navigation' => "{$plural} list navigation",
            'items_list' => "{$plural} list",
            'back_to_items' => "&larr; Back to {$plural}"
        ];
    }
}
