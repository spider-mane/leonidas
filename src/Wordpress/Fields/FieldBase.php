<?php

namespace Backalley\Wordpress\Fields;

use Timber\Timber;
use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\GuctilityBelt;
use Backalley\FormFields\FormField;

abstract class FieldBase
{
    /**
     * form_field
     * 
     * @var string
     */
    public $form_field;

    /**
     * name
     * 
     * @var string
     */
    public $name;

    /**
     * context
     * 
     * @var string
     */
    public $context = '';

    /**
     * manager
     * 
     * @var string
     */
    public $manager;

    /**
     * title
     * 
     * @var string
     */
    public $title;

    /**
     * id
     * 
     * @var string
     */
    public $id;

    /**
     * classlist
     * 
     * @var string
     */
    public $classlist = [];

    /**
     * dataset
     * 
     * @var string
     */
    public $dataset = [];

    /**
     * description
     * 
     * @var string
     */
    public $description;

    /**
     * attributes
     * 
     * @var string
     */
    public $attributes = [];

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix;

    /**
     * width
     * 
     * @var string
     */
    public $width;

    /**
     * meta_key
     * 
     * @var string
     */
    public $meta_key;

    /**
     * meta_prefix
     * 
     * @var string
     */
    public $meta_prefix;

    /**
     * meta_box_template
     * 
     * @var string
     */
    public $meta_box_template;

    /**
     * filter
     * 
     * @var string
     */
    public $filter = 'sanitize_text_field';

    /**
     * validation
     * 
     * @var string
     */
    public $validation;

    /**
     * validation_messages
     * 
     * @var string
     */
    public $validation_errors;

    /**
     * display_cb
     * 
     * @var string
     */
    public $display_cb;

    /**
     * save_cb
     * 
     * @var string
     */
    public $save_cb;

    /**
     * get_data_cb
     * 
     * @var string
     */
    public $get_data_cb;

    /**
     * save_data_cb
     * 
     * @var string
     */
    public $save_data_cb;

    /**
     * 
     */
    public function __construct($args)
    {
        $this->set_manager($args['context']);

        $simple_args = [
            'name',
            'title',
            'width',
            'filter',
            'context',
            'id_prefix',
            'attributes',
            'form_field',
            'validation',
            'description',
            'get_data_cb',
            'save_data_cb',
            'validation_errors',
        ];

        foreach ($simple_args as $arg) {
            $this->$arg = $args[$arg] ?? $this->manager->$arg ?? $this->$arg;
        }

        $array_args = [
            'dataset',
            'classlist',
        ];

        foreach ($array_args as $property) {
            $this->$property = array_merge($args[$property] ?? [], $this->$property);
        }

        $methods = [
            'save',
            'render',
        ];

        foreach ($methods as $method) {
            $property = "{$method}_cb";
            $this->$property = $args[$property] ?? [$this, $method];
        }

        // $args parameter aliases
        $this->filter = $args['sanitize'] ?? $this->filter;
        $this->validation = $args['validate'] ?? $this->validation;

        // $args parameters that are potentially dependent on other properties
        $this->meta_key = $args['meta_key'] ?? $this->name;
        $this->id = $args['id'] ?? "{$this->id_prefix}{$this->name}";
        $this->meta_prefix = $args['meta_prefix'] ?? Backalley::$meta_key_prefix;

        $this->attributes = array_merge($this->attributes, [
            'id' => $this->id,
            'name' => $this->name,
            'class' => array_merge($this->attributes['class'] ?? [], $this->classlist),
            'data' => array_merge($this->attributes['data'] ?? [], $this->dataset),
        ]);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->manager, $name)) {
            return $this->manager->$name(...$arguments);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if (method_exists($this->manager, $name)) {
            return $this->manager->$name(...$arguments);
        }
    }

    public function __toString()
    {
        return $this->form_field;
    }

    public function set_manager($context)
    {
        $manager = GuctilityBelt::arg_to_class($context, "%sFieldManager", "Backalley\\WordPress\\Fields\\Managers");

        $this->manager = new $manager($this);

        return $this;
    }

    /**
     * 
     */
    public function get_data($object)
    {
        if (!empty($callback = $this->get_data_cb)) {
            return $callback($object, $this);
        }

        return $this->manager->get_data($object);
    }

    // public abstract function set_html():
}