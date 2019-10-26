<?php

/**
 * @package Leonidas
 */

namespace WebTheory\Html;

use WebTheory\Html\Attributes\Classlist;
use WebTheory\Html\Attributes\Style;
use WebTheory\Html\Traits\ElementConstructorTrait;

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
    public $id = '';

    /**
     * @var Classlist
     */
    protected $classlist;

    /**
     * @var Style
     */
    protected $styles;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     *
     */
    public function __construct()
    {
        $this->classlist = new Classlist;
        $this->styles = new Style;
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
    public function getClasslist(): Classlist
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
        $this->classlist->set($classlist);

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
        $this->classlist->add($class);

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
        $this->classlist->remove($class);

        return $this;
    }

    /**
     * Get the value of styles
     *
     * @return array
     */
    public function getStyles(): Style
    {
        return $this->styles;
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
     * Add or overwrite a style
     *
     * @param string $property
     * @param string $value
     *
     * @return self
     */
    public function addStyle(string $property, string $value)
    {
        $this->styles->set($property, $value);

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
        $this->styles->remove($style);

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
            ->addAttribute('class', $this->classlist->parse())
            ->addAttribute('style', $this->styles->parse());
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
    abstract public function toHtml(): string;
}
