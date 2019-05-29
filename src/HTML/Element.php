<?php

namespace Backalley\Html;


class Element extends HtmlConstructor
{
    /**
     * tag
     *
     * @var string
     */
    public $tag = 'div';

    /**
     * attributes
     * 
     * @var array
     */
    public $attributes = [];

    /**
     * content
     *
     * @var string
     */
    public $content = '';

    /**
     * children
     *
     * @var array
     */
    public $children = [];

    /**
     *
     */
    public function __construct($args = null, $charset = null)
    {
        parent::__construct($args, $charset);

        $this->set_tag($args['tag'] ?? null);
        $this->set_attributes($args['attributes'] ?? null);
        $this->set_content($args['content'] ?? null);

        foreach ($args['children'] as $child) {

        }
    }

    public static function create($element, $recall = false)
    {
        static $cache;

        if (!$recall) {
            $cache = $element;
        }

        foreach ($element[$children] as $child) {
            $children[$child] = $cache[$child];
            static::create($children, true);
        }
    }

    /**
     * Get tag
     *
     * @return  string
     */
    public function get_tag()
    {
        return $this->tag;
    }

    /**
     * Set tag
     *
     * @param  string  $tag  tag
     *
     * @return  self
     */
    public function set_tag(string $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * get_attributes
     *
     * @param string
     * @return mixed
     */
    public function get_attributes()
    {
        return $this->attributes;
    }

    /**
     * set_attributes
     *
     * @param array $attributes
     * @return self
     */
    public function set_attributes(array $attributes)
    {
        $this->attributes = $attributes ?? $this->attributes;

        return $this;
    }

    /**
     * Get content
     *
     * @return  string
     */
    public function get_content()
    {
        return $this->content;
    }

    /**
     * Set content
     *
     * @param  string  $content  content
     *
     * @return  self
     */
    public function set_content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * 
     */
    public function __toString()
    {
        $element = '';

        $element .= $this->open($this->tag, $this->attributes);
        $element .= $this->content;

        foreach ($this->childern as $child) {
            $element .= $child;
        }

        $element .= $this->close($this->tag);
    }

    /**
     * Get children
     *
     * @return  array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children
     *
     * @param  array  $children  children
     *
     * @return  self
     */
    public function setChildren(array $children = [])
    {
        $this::initialize_children($children);
    }

    /**
     * 
     */
    protected static function initialize_children($children, $recall = false)
    {
        // static $cache;

        // if (!$recall) {
        //     $cache = $children;
        // }

        // foreach ($children as $child => $definition) {
        //     $element['tag'] = $definition['tag'] ?? null;
        //     $element['attributes'] = $definition['attributes'] ?? null;
        //     $element['content'] = $definition['content'] ?? null;

        //     $this->children[] = new static($element);

        //     foreach ($definition['children'] ?? [] as $grandchild) {
        //         $element['children'][$grandchild] = $cache['children'][$grandchild];
        //     }

        //     static::initialize_children($element['children'], true);
        // }
        

        // if (!$recall) {
        //     $cache = null;
        // }
    }
}