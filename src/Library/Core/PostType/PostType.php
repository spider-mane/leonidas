<?php

namespace Leonidas\Library\Core\PostType;

use Leonidas\Library\Core\AbstractWpObjectFacade;

class PostType extends AbstractWpObjectFacade
{
    /**
     *
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     *
     */
    public function register()
    {
        register_post_type($this->name, $this->buildArgs($this->args));

        return $this;
    }

    /**
     *
     */
    public function getRegisteredPostType()
    {
        return get_post_type_object($this->name);
    }

    /**
     *
     */
    protected function getDefaultLabels(string $single, string $plural): array
    {
        $singleLower = strtolower($single);
        $pluralLower = strtolower($plural);

        return [
            'name' => $plural,
            'singular_name' => $single,
            'add_new_item' => "Add New {$single}",
            'edit_item' => "Edit {$single}",
            'new_item' => "New {$single}",
            'view_item' => "View {$single}",
            'view_items' => "View {$plural}",
            'search_items' => "Search {$plural}",
            'not_found' => "No {$pluralLower} found",
            'not_found_in_trash' => "No {$pluralLower} found in Trash",
            'parent_item_colon' => "Parent {$single}:",
            'all_items' => "All {$plural}",
            'archives' => "{$single} Archives",
            'attributes' => "{$single} Attributes",
            'insert_into_item' => "Insert into {$singleLower}",
            'uploaded_to_this_item' => "Uploaded to this {$singleLower}",
            'filter_items_list' => "Filter {$pluralLower} list",
            'items_list_navigation' => "{$plural} list navigation",
            'items_list' => "{$plural} list",
            'item_published' => "{$single} published",
            'item_published_privately' => "{$single} published privately",
            'item_reverted_to_draft' => "{$single} reverted to draft",
            'item_scheduled' => "{$single} scheduled",
            'item_updated' => "{$single} updated",
        ];
    }
}
