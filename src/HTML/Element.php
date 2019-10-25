<?php

namespace WebTheory\Html;


class Element extends AbstractHtmlElementConstructor
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
    public static function create(array $element)
    {
        self::$map = $element;

        $element = new static(self::$map['root']);

        self::$map = [];

        return $element;
    }

    /**
     * Get tag
     *
     * @return  string
     */
    public function getTag()
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
    public function setTag(string $tag)
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
    public function getAttrubutes()
    {
        return $this->attributes;
    }

    /**
     * set_attributes
     *
     * @param array $attributes
     * @return self
     */
    public function setAttrubutes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get content
     *
     * @return  string
     */
    public function getContent()
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
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
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
    public function setChildren(array $children)
    {
        foreach ($children as $child) {
            $this->insertChild(self::$map[$child] ?? $child);
        }

        return $this;
    }

    /**
     *
     */
    public function insertChild($child)
    {
        $this->children[] = is_array($child) ? new static($child) : $child;

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

        foreach ($this->children as $child) {
            $element .= $child;
        }

        $element .= $this->close($this->tag);

        return $element;
    }
}
