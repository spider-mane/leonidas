<?php

namespace Backalley\FormFields;

/**
 * 
 */
trait MultiValueTrait
{
    /**
     * 
     */
    public $items;

    /**
     * 
     */
    public $selected_items;

    /**
     * 
     */
    public $items_name_format;

    /**
     * 
     */
    public $items_attributes;

    /**
     * 
     */
    public $selected_items_attributes;

    /**
     * 
     */
    public function set_items(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * 
     */
    public function set_selected_items(array $selected_items)
    {
        $this->selected_items = $selected_items;
        return $this;
    }

    /**
     * 
     */
    public function set_items_name_format(string $items_name_format)
    {
        $this->items_name_format = $items_name_format;
        return $this;
    }

    /**
     * 
     */
    public function set_items_attributes(array $items_attributes)
    {
        $this->items_attributes = $items_attributes;
        return $this;
    }

    /**
     * 
     */
    public function set_selected_items_attributes(array $selected_items_attributes)
    {
        $this->selected_items_attributes = $selected_items_attributes;
        return $this;
    }

}