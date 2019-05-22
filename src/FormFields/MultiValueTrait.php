<?php

namespace Backalley\FormFields;

/**
 * 
 */
trait MultiValueTrait
{
    /**
     * @var array
     */
    public $items;

    /**
     * @var array
     */
    public $selected_items;

    /**
     * @var array
     */
    public $formatted_items;

    /**
     * @var string
     */
    public $items_name;

    /**
     * @var string
     */
    public $items_value;

    /**
     * @var array
     */
    public $items_attributes;

    /**
     * @var array
     */
    public $selected_items_attributes;

    /**
     * @var array
     */
    public $items_label_attributes;

    /**
     * @var array
     */
    public $selected_items_label_attributes;

    /**
     * 
     */
    protected static $selected_attribute = '';

    /**
     * 
     */
    protected static $item_text = '';

    /**
     * Get the value of items
     *
     * @return  array
     */
    public function get_items()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @param   array  $items  
     *
     * @return  self
     */
    public function set_items(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get the value of selected_items
     *
     * @return  array
     */
    public function get_selected_items()
    {
        return $this->selected_items;
    }

    /**
     * Set the value of selected_items
     *
     * @param   array  $selected_items  
     *
     * @return  self
     */
    public function set_selected_items(array $selected_items)
    {
        $this->selected_items = $selected_items;

        return $this;
    }

    /**
     * Get the value of formatted_items
     *
     * @return  array
     */
    public function get_formatted_items()
    {
        return $this->formatted_items;
    }

    /**
     * Set the value of formatted_items
     *
     * @param   array  $formatted_items  
     *
     * @return  self
     */
    public function set_formatted_items(array $formatted_items)
    {
        $this->formatted_items = $formatted_items;

        return $this;
    }

    /**
     * Get the value of items_name
     *
     * @return  string
     */
    public function get_items_name()
    {
        return $this->items_name;
    }

    /**
     * Set the value of items_name
     *
     * @param   string  $items_name  
     *
     * @return  self
     */
    public function set_items_name(string $items_name)
    {
        $this->items_name = $items_name;

        return $this;
    }

    /**
     * Get the value of items_value
     *
     * @return  string
     */
    public function get_items_value()
    {
        return $this->items_value;
    }

    /**
     * Set the value of items_value
     *
     * @param   string  $items_value  
     *
     * @return  self
     */
    public function set_items_value(string $items_value)
    {
        $this->items_value = $items_value;

        return $this;
    }

    /**
     * Get the value of items_attributes
     *
     * @return  array
     */
    public function get_items_attributes()
    {
        return $this->items_attributes;
    }

    /**
     * Set the value of items_attributes
     *
     * @param   array  $items_attributes  
     *
     * @return  self
     */
    public function set_items_attributes(array $items_attributes)
    {
        $this->items_attributes = $items_attributes;

        return $this;
    }

    /**
     * Get the value of selected_items_attributes
     *
     * @return  array
     */
    public function get_selected_items_attributes()
    {
        return $this->selected_items_attributes;
    }

    /**
     * 
     */
    public function item_attribute($property, $base)
    {
        $property = "items_{$property}";

        return sprintf($this->$property, $base);
    }

    /**
     * 
     */
    public function format_items()
    {
        foreach ($this->items as $value => $item) {

            if (!empty($this::$item_container)) {
                $formated_item[$this::$item_container] = $this->item_container();
            }

            foreach ($this->items_attributes as $attribute => $definition) {
                $formatted_item['attributes'][$attribute] = sprintf($dehinition, $item);
            }

            $formatted_item[$this->item_text] = $this->item_text === 'content' ? $item : $this->item_label($item, $text);
            $formatted_item['attributes']['name'] = empty($this->items_name) ? $value : $this->item_attribute('name', $item);
            $formatted_item['attributes']['value'] = empty($this->items_value) ? $value : $this->item_attribute('value', $item);

            if (in_array($item, $this->selected_items)) {
                $formatted_item['attributes'][$this->selected_attribute] = true;

                foreach ($this->selected_items_attributes as $attribute => $definition) {

                }
            }

            $this->formatted_items[] = $formatted_item;
        }
    }

    /**
     * 
     */
    public function item_label($item, $text)
    {
        $item_text = [
            'content' => $text,
            'attributes' => []
        ];

        foreach ($this->item_label_attributes as $attribute => $definition) {
            $item_text['attributes'][$attribute] = sprint($definition, $text);
        }

        if (in_array($item, $this->selected_items)) {
            foreach ($this->selected_items_label_attributes as $attribute => $definition) {

            }
        }

        return $item_text;
    }

    /**
     * 
     */
    public function item_container($item, $text)
    {

        $item_container = [
            'attributes' => [],
        ];

        foreach ($this->item_container_attributes as $attribute => $definition) {
            $item_container['attributes'][$attribute] = sprint($definition, $text);
        }

        if (in_array($item, $this->selected_items)) {
            foreach ($this->selected_items_container_attributes as $attribute => $definition) {

            }
        }

        return $item_text;
    }
}

    