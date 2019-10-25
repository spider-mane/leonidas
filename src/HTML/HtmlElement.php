<?php

namespace WebTheory\Html;

class HtmlElement extends AbstractHtmlElement
{
    /**
     *
     */
    protected $tag = 'div';

    /**
     *
     */
    protected $innerHtml = '';

    /**
     *
     */
    public function toHtml(): string
    {
        return $this->tag($this->tag, $this->innerHtml, $this->attributes);
    }

    /**
     * Get the value of tag
     *
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the value of tag
     *
     * @param mixed $tag
     *
     * @return self
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get the value of innerHtml
     *
     * @return mixed
     */
    public function getInnerHtml()
    {
        return $this->innerHtml;
    }

    /**
     * Set the value of innerHtml
     *
     * @param mixed $innerHtml
     *
     * @return self
     */
    public function setInnerHtml($innerHtml)
    {
        $this->innerHtml = $innerHtml;

        return $this;
    }
}
