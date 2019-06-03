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
    protected $children = [];

    /**
     * map
     * 
     * @var array
     */
    protected static $map = [];

    /**
     *
     */
    protected function __construct(array $element, string $charset = null)
    {
        parent::__construct($charset);

        $properties = ['tag', 'attributes', 'content', 'children'];

        foreach ($properties as $property) {
            if (isset($element[$property])) {
                $setter = "set_{$property}";
                $this->$setter($element[$property]);
            }
        }
    }

    /**
     * 
     */
    public static function create(array $element, string $charset = null)
    {
        self::$map = $element;

        $element = new static(self::$map['root'], $charset);

        self::$map = [];

        return $element;
    }

    /**
     * 
     */
    public function __toString()
    {
        $element = '';

        $element .= $this->open($this->tag, $this->attributes);
        $element .= $this->content;

        foreach ($this->children as $child) {
            $element .= $child;
        }

        $element .= $this->close($this->tag);

        return $element;
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
        $this->attributes = $attributes;

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
     * Get children
     *
     * @return  array
     */
    public function get_chilren()
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
    public function set_children(array $children)
    {
        foreach ($children as $child) {
            $this->insert_child(self::$map[$child] ?? $child);
        }

        return $this;
    }

    /**
     * 
     */
    public function insert_child($child)
    {
        $this->children[] = is_array($child) ? new static($child, $this->charset) : $child;

        return $this;
    }
}