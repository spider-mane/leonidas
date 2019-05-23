<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Backalley;
use Backalley\WordPress\Term\TermFieldBaseTrait;
use Backalley\WordPress\MetaBox\PostMetaBoxFieldBaseTrait;


/**
 * @package Backalley
 */
class SelectField extends FieldBase
{
    /**
     * options
     * 
     * @var string
     */
    public $options = [];

    /**
     * selected
     * 
     * @var string
     */
    public $selected;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);
        $this->options = $args['options'] ?? $this->options;
        $this->selected = $args['selected'] ?? $this->selected;
    }

    /**
     * 
     */
    public function generate_field($object = null)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'form_element' => 'select',
            'options' => $this->options,
            'selected' => $this->selected ?? $this->get_data($object),
            'attributes' => $this->attributes
        ];
    }
}