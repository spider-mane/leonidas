<?php

namespace Backalley\Html;

use DOMElement;
use Backalley\Html\Traits\ElementConstructorTrait;

/**
 * @package Backalley-Core
 */
abstract class AbstractHtmlElement
{
    use ElementConstructorTrait;

    /**
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * @var string
     */
    public $id;

    /**
     * @var array
     */
    protected $classlist = [];

    /**
     * @var array
     */
    protected $styles = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     *
     */
    public function __construct()
    {
        // do something maybe
    }

    /**
     * Get the value of charset
     *
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     *
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string  $id
     *
     * @return self
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of classlist
     *
     * @return array
     */
    public function getClasslist(): array
    {
        return $this->classlist;
    }

    /**
     * Set the value of classlist
     *
     * @param array $classlist
     *
     * @return self
     */
    public function setClasslist(array $classlist)
    {
        foreach ($classlist as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * Set the value of classlist
     *
     * @param array $classlist
     *
     * @return self
     */
    protected function resetClasslist(array $classlist = [])
    {
        $this->classlist = [];
        $this->setClasslist($classlist);

        return $this;
    }

    /**
     * Set the value of classlist
     *
     * @param array $class
     *
     * @return self
     */
    public function addClass(string $class)
    {
        $this->classlist[] = $class;

        return $this;
    }

    /**
     * Set the value of classlist
     *
     * @param string $class
     *
     * @return self
     */
    public function removeClass(string $class)
    {
        while (in_array($class, $this->classlist)) {
            unset($this->classlist[array_search($class, $this->classlist)]);
        }

        return $this;
    }

    /**
     * Get the value of styles
     *
     * @return array
     */
    public function getStyles(): array
    {
        return $this->classlist;
    }

    /**
     * Set the value of styles
     *
     * @param array $styles
     *
     * @return self
     */
    public function setStyles(array $styles)
    {
        foreach ($styles as $property => $value) {
            $this->addStyle($property, $value);
        }

        return $this;
    }

    /**
     * Reset the value of styles
     *
     * @param array $styles
     *
     * @return self
     */
    protected function resetStyles(array $styles = [])
    {
        $this->styles = [];
        $this->setStyles($styles);

        return $this;
    }

    /**
     * Add or overwrite a style
     *
     * @param string $property
     * @param string $value
     *
     * @return self
     */
    public function addStyle(string $property, string $value)
    {
        $this->styles[$property] = $value;

        return $this;
    }

    /**
     * Remove a style
     *
     * @param string $style
     *
     * @return self
     */
    public function removeStyle(string $style)
    {
        while (in_array($style, $this->styles)) {
            unset($this->styles[array_search($style, $this->styles)]);
        }

        return $this;
    }

    /**
     * Get the value of attributes
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Add individual attribute
     *
     * @param array $attribute
     *
     * @return self
     */
    public function addAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return $this
            ->addAttribute('id', $this->id)
            ->addAttribute('class', $this->classlist);
    }

    /**
     *
     */
    final public function __toString()
    {
        return $this->toHtml();
    }

    /**
     *
     */
    abstract public function toHtml();
}
